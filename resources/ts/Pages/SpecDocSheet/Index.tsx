import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import { PageProps } from "@/types";
import { Head, Link } from "@inertiajs/react";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import "@scss/pages/spec_doc_sheet/index.scss";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import { Breadcrumb } from "@/types/Breadcrumb";
import Breadcrumbs from "@/Components/Breadcrumbs";

type Props = PageProps & {
  specDoc: SpecificationDocument;
  specDocSheets: SpecDocSheet[];
  sheetStatuses: { [key: number]: string };
  breadcrumbs: Breadcrumb[];
};

const Index: React.FC<Props> = ({
  auth,
  specDoc,
  specDocSheets,
  sheetStatuses,
  breadcrumbs,
}) => {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800 leading-tight">
          Specification document sheet list
        </h2>
      }
    >
      <Head title="Specification document sheet list" />

      <Breadcrumbs breadcrumbs={breadcrumbs} />

      <section className="spec-doc-sheet">
        <Link
          href={route("specDocs.index", {
            projectId: specDoc.projectId,
          })}
          className="spec-doc-sheet__backBtn"
        >
          Back to specification document list
        </Link>

        <div className="spec-doc-sheet__head">
          <h3>{specDoc.title}</h3>
          <ReactMarkdown remarkPlugins={[remarkGfm]} className="markdown">
            {specDoc.summary}
          </ReactMarkdown>
          Responsible person: {specDoc.userName}
        </div>
        {auth.user.id === specDoc.userId && (
          <Link
            href={route("specDocs.edit", {
              projectId: specDoc.projectId,
              specDocId: specDoc.id,
            })}
            className="spec-doc-sheet__editBtn"
          >
            Edit
          </Link>
        )}
      </section>

      <ul>
        {specDocSheets.length > 0 ? (
          specDocSheets.map((specDocSheet) => (
            <li key={specDocSheet.id}>
              <Link
                href={route("specDocSheets.show", {
                  projectId: specDoc.projectId,
                  specDocId: specDoc.id,
                  specDocSheetId: specDocSheet.id,
                })}
              >
                <h3>{specDocSheet.execEnvName}</h3>
                <span>{sheetStatuses[specDocSheet.statusId]}</span>
              </Link>
            </li>
          ))
        ) : (
          <li>Specification document does not exist.</li>
        )}
      </ul>
    </AuthenticatedLayout>
  );
};

export default Index;
