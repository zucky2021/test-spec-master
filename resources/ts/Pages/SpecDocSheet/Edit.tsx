import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React, {
  FormEventHandler,
  useCallback,
  useEffect,
  useState,
} from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import { PageProps } from "@/types";
import { Head, Link, useForm, usePage } from "@inertiajs/react";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import "@scss/pages/spec_doc_item/edit.scss";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import Dropdown from "@/Components/Dropdown";
import PrimaryButton from "@/Components/PrimaryButton";
import { Transition } from "@headlessui/react";
import { SpecDocItem } from "@/types/SpecDocItem";
import InputError from "@/Components/InputError";
import { Flash } from "@/types/Flash";
import SlideAlert from "@/Components/SlideAlert";

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

  const handleInputChange = useCallback((
    index: number,
    field: keyof FormDataItem,
    value: string,
  ): void => {
    const newItems = [...data.items];
    newItems[index][field] = value;
    setData("items", newItems);
  }, [data.items, setData]);

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

      return () => clearTimeout(timer);
    } catch (error) {
      console.error("Failed to copy the URL: ", error);
    }
  }, [execUrl]);

  useEffect(() => {
    handleShare();
  }, [handleShare]);

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800 leading-tight">
          Specification document sheet
        </h2>
      }
    >
      <Head title="Specification document sheet" />

      <section className="spec-doc-item-edit">
        <Link
          href={route("specDocs.edit", {
            projectId: specDoc.projectId,
            specDocId: specDoc.id,
          })}
          className="back-link"
        >
          Back to specification document edit page
        </Link>

        <section className="spec-doc-item-edit__description">
          <h3>{specDoc.title}</h3>
          <h4>{specDocSheet.execEnvName}</h4>
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
          <p>
            Updated at: <time>{specDocSheet.updatedAt}</time>
          </p>
        </section>

        <a
          href={route("specDocSheets.preview", {
            projectId: specDoc.projectId,
            specDocId: specDoc.id,
            specDocSheetId: specDocSheet.id,
          })}
          target="_blank"
          className="spec-doc-sheet-edit__preview-link"
        >
          Preview
        </a>

        <button className="spec-doc-item-edit__share-btn" onClick={handleShare}>
          Share
        </button>

        <SlideAlert isShow={isShowAlert}>
          <h4>URL copied to clipboard!</h4>
          <p>{execUrl}</p>
        </SlideAlert>

        <form onSubmit={handleSubmit}>
          {flash.error && (
            <div className="spec-doc-item-edit__alert-error">{flash.error}</div>
          )}

          <ul className="spec-doc-item-edit__inputList">
            <li>
              <div>Target area</div>
              <div>Check detail</div>
              <div>Remark</div>
              <div></div>
            </li>
            {data.items.map((item, index) => (
              <li key={index}>
                <div>
                  <textarea
                    name={`items[${index}].targetArea`}
                    value={item.targetArea}
                    onChange={(e) =>
                      handleInputChange(index, "targetArea", e.target.value)
                    }
                  />
                  <InputError
                    message={
                      formErrors[
                        `items.${index}.targetArea` as keyof typeof formErrors
                      ]
                    }
                  />
                </div>
                <div>
                  <textarea
                    name={`items[${index}].checkDetail`}
                    value={item.checkDetail}
                    onChange={(e) =>
                      handleInputChange(index, "checkDetail", e.target.value)
                    }
                  />
                  <InputError
                    message={
                      formErrors[
                        `items.${index}.checkDetail` as keyof typeof formErrors
                      ]
                    }
                  />
                </div>
                <div>
                  <textarea
                    name={`items[${index}].remark`}
                    value={item.remark}
                    onChange={(e) =>
                      handleInputChange(index, "remark", e.target.value)
                    }
                  />
                  <InputError
                    message={
                      formErrors[
                        `items.${index}.remark` as keyof typeof formErrors
                      ]
                    }
                  />
                </div>
                <div>
                  <Dropdown>
                    <Dropdown.Trigger>
                      <button type="button">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          className="h-4 w-4 text-gray-400"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                        >
                          <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                        </svg>
                      </button>
                    </Dropdown.Trigger>
                    <Dropdown.Content>
                      <button
                        type="button"
                        onClick={() => {
                          const newItems = data.items.filter(
                            (_, i) => i !== index,
                          );
                          setData("items", newItems);
                        }}
                      >
                        Delete
                      </button>
                      <div>Copy</div>
                    </Dropdown.Content>
                  </Dropdown>
                </div>
              </li>
            ))}
          </ul>
          <div className="mt-4">
            <button type="button" onClick={handleAddRow} className="mt-4">
              Add
            </button>
          </div>

          <div className="flex items-center gap-4 mt-4">
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
      </section>
    </AuthenticatedLayout>
  );
};

export default Edit;
