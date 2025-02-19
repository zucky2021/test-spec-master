import { SpecDocItem } from "@/types/SpecDocItem";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import axios from "axios";
import { ReactElement, useCallback, useState } from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";

type Props = {
  specDocItems: SpecDocItem[];
  specDoc: SpecificationDocument;
  specDocSheet: SpecDocSheet;
  statuses: { [key: number]: string };
};

type ToggleStatusResponse = {
  newStatusId: number;
};

const SheetPartial = ({
  specDocItems,
  specDoc,
  specDocSheet,
  statuses,
}: Props): ReactElement => {
  const [items, setItems] = useState<SpecDocItem[]>(specDocItems);
  const [loading, setLoading] = useState<number | null>(null);

  const toggleStatus = useCallback(
    async (index: number, itemId: number): Promise<void> => {
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
    },
    [items],
  );

  return (
    <table className="border-black border-2 w-fit max-w-screen-xl overflow-scroll mx-auto">
      <caption className="font-lg text-center font-serif">
        Let's testing!
      </caption>
      <thead className="bg-gray-400">
        <tr>
          <th className="w-10 text-center border-black border">No.</th>
          <th className="w-80 text-center border-black border">Target area</th>
          <th className="w-80 text-center border-black border">Check detail</th>
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
                className="bg-blue-600 text-white p-1 my-1 mx-auto block rounded-md hover:opacity-50"
              >
                {loading === item.id ? "Updating..." : statuses[item.statusId]}
              </button>
            </td>
          </tr>
        ))}
      </tbody>
      <tfoot>
        <tr>
          <th colSpan={5} className="text-xl font-bod font-serif">
            That's all!
            <br /> Thank you very much!
          </th>
        </tr>
      </tfoot>
    </table>
  );
};

export default SheetPartial;
