import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React, { FormEventHandler, useCallback, useState } from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import { PageProps } from "@/types";
import { Head, Link, useForm, usePage } from "@inertiajs/react";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import PrimaryButton from "@/Components/PrimaryButton";
import { Transition } from "@headlessui/react";
import { SpecDocItem } from "@/types/SpecDocItem";
import InputError from "@/Components/InputError";
import { Flash } from "@/types/Flash";
import SlideAlert from "@/Components/SlideAlert";
import "@scss/pages/spec_doc_item/edit.scss";

type Props = PageProps & {
  specDoc: SpecificationDocument;
  specDocSheet: SpecDocSheet;
  specDocItems: SpecDocItem[];
  flash: Flash;
};

type FormDataItem = {
  targetArea: string;
  checkDetail: string;
  remark: string;
};

type FormErrors = {
  [key: string]: string;
};

const Edit: React.FC<Props> = ({
  auth,
  specDoc,
  specDocSheet,
  specDocItems,
}) => {
  const { data, setData, put, errors, processing, recentlySuccessful } =
    useForm<{
      items: FormDataItem[];
    }>({
      items: specDocItems.map((item) => ({
        targetArea: item.targetArea || "",
        checkDetail: item.checkDetail || "",
        remark: item.remark || "",
      })),
    });

  const formErrors = errors as FormErrors;

  const handleAddRow = (): void => {
    setData("items", [
      ...data.items,
      { targetArea: "", checkDetail: "", remark: "" },
    ]);
  };

  const handleInputChange = useCallback(
    (index: number, field: keyof FormDataItem, value: string): void => {
      const newItems = [...data.items];
      newItems[index][field] = value;
      setData("items", newItems);
    },
    [data.items, setData],
  );

  const handleSubmit: FormEventHandler = (e) => {
    e.preventDefault();
    put(
      route("specDocItems.store", {
        projectId: specDoc.projectId,
        specDocId: specDoc.id,
        specDocSheetId: specDocSheet.id,
      }),
    );
  };

  const { flash } = usePage<Props>().props;

  const [isShowAlert, setIsShowAlert] = useState(false);

  const execUrl = route("specDocSheets.show", {
    projectId: specDoc.projectId,
    specDocId: specDoc.id,
    specDocSheetId: specDocSheet.id,
  });

  const handleShare = useCallback(async () => {
    try {
      await navigator.clipboard.writeText(execUrl);
      setIsShowAlert(true);
      const timer = setTimeout(() => {
        setIsShowAlert(false);
      }, 5000);

      return (): void => clearTimeout(timer);
    } catch (error) {
      console.error("Failed to copy the URL: ", error);
    }
  }, [execUrl]);

  return (
    <AuthenticatedLayout user={auth.user} header={<h1>Edit items</h1>}>
      <Head title="Edit items" />

      <section className="edit-item">
        <Link
          href={route("specDocs.edit", {
            projectId: specDoc.projectId,
            specDocId: specDoc.id,
          })}
          className="edit-item__back"
        >
          Back
        </Link>

        <section className="edit-item__description">
          <h2>{specDoc.title}</h2>
          <h3>
            Environment: <span>{specDocSheet.execEnvName}</span>
          </h3>
          <details>
            <summary>Summary</summary>
            <ReactMarkdown
              remarkPlugins={[remarkGfm]}
              className="markdown"
              components={{
                a: ({ href, children }) => (
                  <a href={href} target="_blank">
                    {children}
                  </a>
                ),
              }}
            >
              {specDoc.summary}
            </ReactMarkdown>
          </details>
        </section>

        <div className="edit-item__utility">
          <p className="edit-item__utility-updated-at">
            Updated at: <time>{specDocSheet.updatedAt}</time>
          </p>

          <div className="edit-item__utility-row">
            <a
              href={route("specDocSheets.preview", {
                projectId: specDoc.projectId,
                specDocId: specDoc.id,
                specDocSheetId: specDocSheet.id,
              })}
              target="_blank"
              className="edit-item__utility-preview"
            >
              Preview
            </a>

            <button className="edit-item__utility-share" onClick={handleShare}>
              Share
            </button>
            <SlideAlert isShow={isShowAlert}>
              <h4>URL copied to clipboard!</h4>
              <p>{execUrl}</p>
            </SlideAlert>
          </div>
        </div>
      </section>

      <form onSubmit={handleSubmit}>
        {flash.error && (
          <div className="spec-doc-item-edit__alert-error">{flash.error}</div>
        )}

        <table className="edit-item__inputs">
          <caption>Edit item form</caption>
          <thead className="edit-item__inputs-head">
            <tr>
              <th>Target area</th>
              <th>Check detail</th>
              <th>Remark</th>
              <th className="action-col">Action</th>
            </tr>
          </thead>
          <tbody>
            {data.items.map((item, index) => (
              <tr key={index}>
                <td>
                  {/* TODO:textareaの高さを可変にする(可能であれば列単位で) */}
                  <textarea
                    name={`items[${index}].targetArea`}
                    value={item.targetArea}
                    onChange={(e) =>
                      handleInputChange(index, "targetArea", e.target.value)
                    }
                    rows={5}
                    placeholder="対象箇所"
                  />
                  <InputError
                    message={
                      formErrors[
                        `items.${index}.targetArea` as keyof typeof formErrors
                      ]
                    }
                  />
                </td>
                <td>
                  <textarea
                    name={`items[${index}].checkDetail`}
                    value={item.checkDetail}
                    onChange={(e) =>
                      handleInputChange(index, "checkDetail", e.target.value)
                    }
                    rows={5}
                    placeholder="期待値"
                  />
                  <InputError
                    message={
                      formErrors[
                        `items.${index}.checkDetail` as keyof typeof formErrors
                      ]
                    }
                  />
                </td>
                <td>
                  <textarea
                    name={`items[${index}].remark`}
                    value={item.remark}
                    onChange={(e) =>
                      handleInputChange(index, "remark", e.target.value)
                    }
                    rows={5}
                    placeholder="備考"
                  />
                  <InputError
                    message={
                      formErrors[
                        `items.${index}.remark` as keyof typeof formErrors
                      ]
                    }
                  />
                </td>
                <td>
                  <button
                    onClick={() => {
                      const newItems = data.items.filter((_, i) => i !== index);
                      setData("items", newItems);
                    }}
                    className="w-16 p-2 rounded-lg my-2 mx-auto bg-red-600 text-white block hover:scale-110 transition-transform duration-500"
                  >
                    Delete
                  </button>
                  <button
                    onClick={(e) => {
                      e.preventDefault();
                      const newItem = { ...item };
                      const newItems = [...data.items];
                      newItems.splice(index + 1, 0, newItem);
                      setData("items", newItems);
                    }}
                    className="w-16 p-2 rounded-lg my-2 mx-auto bg-gray-400 block hover:scale-110 transition-transform duration-500"
                  >
                    Copy
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
          <tfoot>
            <tr>
              <td colSpan={4}>
                <button
                  type="button"
                  onClick={handleAddRow}
                  className="text-center w-full bg-green-500 text-white font-bold font-serif p-2 hover:duration-150"
                >
                  Add
                </button>
              </td>
            </tr>
          </tfoot>
        </table>

        <div className="flex items-center mt-4 mx-auto w-64 justify-between">
          <PrimaryButton disabled={processing}>Save</PrimaryButton>
          {flash.success && (
            <Transition
              show={recentlySuccessful}
              enter="transition ease-in-out"
              enterFrom="opacity-0"
              leave="transition ease-in-out"
              leaveTo="opacity-0"
            >
              <p className="text-sm text-gray-600">{flash.success}</p>
            </Transition>
          )}
        </div>
      </form>
    </AuthenticatedLayout>
  );
};

export default Edit;
