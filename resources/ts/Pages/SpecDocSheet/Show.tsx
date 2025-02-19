import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { ReactElement, useState } from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import { PageProps } from "@/types";
import { Head, Link } from "@inertiajs/react";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import { SpecDocItem } from "@/types/SpecDocItem";
import axios from "axios";
import TesterPartial from "./Partials/TesterPartial";
import Breadcrumbs from "@/Components/Breadcrumbs";
import { Breadcrumb } from "@/types/Breadcrumb";

type Props = PageProps & {
  specDoc: SpecificationDocument;
  specDocSheet: SpecDocSheet;
  specDocItems: SpecDocItem[];
  statuses: { [key: number]: string };
  breadcrumbs: Breadcrumb[];
};

type ToggleStatusResponse = {
  newStatusId: number;
};

const Show = ({
  auth,
  specDoc,
  specDocSheet,
  specDocItems,
  statuses,
  breadcrumbs,
}: Props): ReactElement => {
  const [items, setItems] = useState<SpecDocItem[]>(specDocItems);
  const [loading, setLoading] = useState<number | null>(null);

  const toggleStatus = async (index: number, itemId: number): Promise<void> => {
    setLoading(itemId);
    try {
      const response = await axios.patch<ToggleStatusResponse>(
        route("specDocItems.update", {
          projectId: specDoc.projectId,
          specDocId: specDoc.id,
          specDocSheetId: specDocSheet.id,
          specDocItemId: itemId,
        }),
      );

      const updatedItems = [...items];
      updatedItems[index].statusId = response.data.newStatusId;
      setItems(updatedItems);
    } catch (error) {
      console.error("Failed to toggle status: ", error);
    } finally {
      setLoading(null);
    }
  };

  // FIXME:現状一つのitemが更新される度に再レンダリングされるためmemo化

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h1 className="font-semibold text-xl text-gray-800 leading-tight">
          Execute test
        </h1>
      }
    >
      <Head title="Execute test" />

      <Breadcrumbs breadcrumbs={breadcrumbs} />

      <section className="mx-auto max-w-screen-lg">
        <Link
          href={route("specDocSheets.index", {
            projectId: specDoc.projectId,
            specDocId: specDoc.id,
          })}
          className="font-serif bg-gray-500 text-white rounded-full w-20 block text-center p-2 my-5 hover:opacity-50"
        >
          Back
        </Link>

        <div className="shadow-md rounded-md p-4 ">
          <h2 className="text-2xl font-bold">{specDoc.title}</h2>
          <h3 className="text-xl font-serif my-2">
            {specDocSheet.execEnvName}
          </h3>
          <details className="shadow-md p-2 rounded-md text-lg">
            <summary className="cursor-pointer hover:opacity-50">
              Summary
            </summary>
            <ReactMarkdown remarkPlugins={[remarkGfm]} className="markdown">
              {specDoc.summary}
            </ReactMarkdown>
          </details>
          <p className="shadow-md max-w-fit p-2 mx-auto mt-2 rounded-full text-md font-serif">
            Updated at:
            <time className="text-green-500 ml-2 text-lg">
              {specDocSheet.updatedAt}
            </time>
          </p>
        </div>

        <TesterPartial
          authUser={auth.user}
          specDoc={specDoc}
          specDocSheetId={specDocSheet.id}
        />
      </section>

      <table className="border-black border-2 w-fit max-w-screen-xl overflow-scroll mx-auto">
        <thead className="bg-gray-400">
          <tr>
            <th className="w-10 text-center border-black border">No.</th>
            <th className="w-80 text-center border-black border">
              Target area
            </th>
            <th className="w-80 text-center border-black border">
              Check detail
            </th>
            <th className="w-48 text-center border-black border">Remark</th>
            <th className="w-32 text-center border-black border">Status</th>
          </tr>
        </thead>
        <tbody>
          {items.map((item, index) => (
            <tr key={index}>
              <td className="border-black border text-center font-bold font-serif">
                {index + 1}
              </td>
              <td className="border-black border p-1">
                <ReactMarkdown remarkPlugins={[remarkGfm]} className="markdown">
                  {item.targetArea}
                </ReactMarkdown>
              </td>
              <td className="border-black border p-1">
                <ReactMarkdown remarkPlugins={[remarkGfm]} className="markdown">
                  {item.checkDetail}
                </ReactMarkdown>
              </td>
              <td className="border-black border p-1">
                <ReactMarkdown remarkPlugins={[remarkGfm]} className="markdown">
                  {item.remark}
                </ReactMarkdown>
              </td>
              <td className="border-black border">
                <button
                  type="button"
                  onClick={() => toggleStatus(index, item.id)}
                  disabled={loading === item.id}
                  className="bg-blue-600 text-white p-1 mx-auto block rounded-md hover:opacity-50"
                >
                  {loading === item.id
                    ? "Updating..."
                    : statuses[item.statusId]}
                </button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </AuthenticatedLayout>
  );
};

export default Show;
