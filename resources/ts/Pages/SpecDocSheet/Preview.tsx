import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import { PageProps } from "@/types";
import { Head, Link } from "@inertiajs/react";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import "@scss/pages/spec_doc_item/show.scss";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import { SpecDocItem } from "@/types/SpecDocItem";

type Props = PageProps & {
    specDoc: SpecificationDocument;
    specDocSheet: SpecDocSheet;
    specDocItems: SpecDocItem[];
    statuses: { [key: number]: string };
};

const Show: React.FC<Props> = ({
    auth,
    specDoc,
    specDocSheet,
    specDocItems,
    statuses,
}) => {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Preview specification document sheet
                </h2>
            }
        >
            <Head title="Preview specification document sheet" />

            <section className="spec-doc-exec">
                <Link
                    href={route("specDocSheets.index", {
                        projectId: specDoc.projectId,
                        specDocId: specDoc.id,
                    })}
                    className="back-link"
                >
                    Back to sheet list page
                </Link>

                <div className="spec-doc-item-edit__description">
                    <h3>{specDoc.title}</h3>
                    <h4>{specDocSheet.execEnvName}</h4>
                    <details>
                        <summary>Summary</summary>
                        <ReactMarkdown
                            remarkPlugins={[remarkGfm]}
                            className="markdown"
                        >
                            {specDoc.summary}
                        </ReactMarkdown>
                    </details>
                    <p>
                        Updated at: <time>{specDocSheet.updatedAt}</time>
                    </p>
                </div>

                <ul className="spec-doc-item-edit__inputList">
                    <li>
                        <div>No.</div>
                        <div>Target area</div>
                        <div>Check detail</div>
                        <div>Remark</div>
                        <div></div>
                    </li>
                    {specDocItems.map((item, index) => (
                        <li key={index}>
                            <div>
                                {index + 1}
                            </div>
                            <div>
                                <ReactMarkdown remarkPlugins={[remarkGfm]}>
                                    {item.targetArea}
                                </ReactMarkdown>
                            </div>
                            <div>
                                <ReactMarkdown remarkPlugins={[remarkGfm]}>
                                    {item.checkDetail}
                                </ReactMarkdown>
                            </div>
                            <div>
                                <ReactMarkdown remarkPlugins={[remarkGfm]}>
                                    {item.remark}
                                </ReactMarkdown>
                            </div>
                            <div>
                                <button
                                    type="button"
                                >
                                    {statuses[item.statusId]}
                                </button>
                            </div>
                        </li>
                    ))}
                </ul>
            </section>
        </AuthenticatedLayout>
    );
};

export default Show;
