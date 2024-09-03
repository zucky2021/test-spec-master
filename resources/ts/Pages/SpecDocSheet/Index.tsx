import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import { PageProps } from "@/types";
import { Head, Link } from "@inertiajs/react";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import "@scss/pages/spec_doc_sheet/index.scss";
import { SpecificationDocument } from "@/types/SpecificationDocument";

type Props = PageProps & {
    specDoc: SpecificationDocument;
    specDocSheets: SpecDocSheet[];
};

const Index: React.FC<Props> = ({ auth, specDoc, specDocSheets }) => {
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
                                href={`/project/${specDocSheet.specDocId}/spec-doc/${specDocSheet.id}`}
                            >
                                <h3>{specDocSheet.execEnvName}</h3>
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
