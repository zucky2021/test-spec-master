import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { ReactElement } from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import { PageProps } from "@/types";
import { Head, Link } from "@inertiajs/react";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import { SpecDocItem } from "@/types/SpecDocItem";
import TesterPartial from "./Partials/TesterPartial";
import Breadcrumbs from "@/Components/Breadcrumbs";
import { Breadcrumb } from "@/types/Breadcrumb";
import SheetPartial from "./Partials/SheetPartial";

type Props = PageProps & {
  specDoc: SpecificationDocument;
  specDocSheet: SpecDocSheet;
  specDocItems: SpecDocItem[];
  statuses: { [key: number]: string };
  breadcrumbs: Breadcrumb[];
};

const Show = ({
  auth,
  specDoc,
  specDocSheet,
  specDocItems,
  statuses,
  breadcrumbs,
}: Props): ReactElement => {
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

      <SheetPartial
        specDocItems={specDocItems}
        specDoc={specDoc}
        specDocSheet={specDocSheet}
        statuses={statuses}
      />
    </AuthenticatedLayout>
  );
};

export default Show;
