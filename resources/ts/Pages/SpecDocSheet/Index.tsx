import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import { PageProps } from "@/types";
import { Head, Link } from "@inertiajs/react";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import { Breadcrumb } from "@/types/Breadcrumb";
import Breadcrumbs from "@/Components/Breadcrumbs";
import "@scss/pages/spec_doc_sheet/index.scss";

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
        <h1 className="text-xl text-center font-serif font-bold">
          Specification document sheets
        </h1>
      }
    >
      <Head title="Specification document sheets" />

      <Breadcrumbs breadcrumbs={breadcrumbs} />

      <section className="spec-doc-sheet">
        <div className="spec-doc-sheet__btn-row">
          <Link
            href={route("specDocs.index", {
              projectId: specDoc.projectId,
            })}
            className="spec-doc-sheet__back-btn"
          >
            Back
          </Link>

          {auth.user.id == specDoc.userId && (
            <Link
              href={route("specDocs.edit", {
                projectId: specDoc.projectId,
                specDocId: specDoc.id,
              })}
              className="spec-doc-sheet__edit-btn"
            >
              Edit
            </Link>
          )}
        </div>

        <div className="spec-doc-sheet__head">
          <h2>{specDoc.title}</h2>
          <ReactMarkdown
            remarkPlugins={[remarkGfm]}
            remarkRehypeOptions={{ allowDangerousHtml: false }}
            components={{
              a: ({ ...props }) => (
                <a {...props} target="_blank" rel="noopener noreferrer" />
              ),
            }}
            className="markdown spec-doc-sheet__head-summary"
          >
            {specDoc.summary}
          </ReactMarkdown>
          <dl>
            <dt>Responsible person name:</dt>
            <dd>{specDoc.userName}</dd>
          </dl>
        </div>

        <ul className="spec-doc-sheet__list">
          {specDocSheets.length > 0 ? (
            specDocSheets.map((specDocSheet) => (
              <li key={specDocSheet.id} className="spec-doc-sheet__list-item">
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
            <li className="spec-doc-sheet__list-not-exists">
              Specification document does not exist.
            </li>
          )}
        </ul>
      </section>
    </AuthenticatedLayout>
  );
};

export default Index;
