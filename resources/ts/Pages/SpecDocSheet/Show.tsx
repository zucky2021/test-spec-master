import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React, { useState } from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import { PageProps } from "@/types";
import { Head, Link } from "@inertiajs/react";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import "@scss/pages/spec_doc_item/show.scss";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import { SpecDocItem } from "@/types/SpecDocItem";
import axios from "axios";
import Tester from "./Partials/Tester";
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

const Show: React.FC<Props> = ({
    auth,
    specDoc,
    specDocSheet,
    specDocItems,
    statuses,
    breadcrumbs,
}) => {
    const [items, setItems] = useState<SpecDocItem[]>(specDocItems);
    const [loading, setLoading] = useState<number | null>(null);

    const toggleStatus = async (index: number, itemId: number) => {
        setLoading(itemId);
        try {
            const response = await axios.patch<ToggleStatusResponse>(
                route("specDocItems.update", {
                    projectId: specDoc.projectId,
                    specDocId: specDoc.id,
                    specDocSheetId: specDocSheet.id,
                    specDocItemId: itemId,
                })
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

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Execute test
                </h2>
            }
        >
            <Head title="Execute test" />

            <Breadcrumbs breadcrumbs={breadcrumbs} />

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

                <Tester
                    authUser={auth.user}
                    specDoc={specDoc}
                    specDocSheetId={specDocSheet.id}
                />

                <ul className="spec-doc-item-edit__inputList">
                    <li>
                        <div>No.</div>
                        <div>Target area</div>
                        <div>Check detail</div>
                        <div>Remark</div>
                        <div></div>
                    </li>
                    {items.map((item, index) => (
                        <li key={index}>
                            <div>{index + 1}</div>
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
                                    onClick={() => toggleStatus(index, item.id)}
                                    disabled={loading === item.id}
                                >
                                    {loading === item.id
                                        ? "Updating..."
                                        : statuses[item.statusId]}
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
