import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React, { useEffect, useState } from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import { PageProps } from "@/types";
import { Head, Link } from "@inertiajs/react";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import "@scss/pages/spec_doc_item/show.scss";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import { SpecDocItem } from "@/types/SpecDocItem";
import axios from "axios";

type Props = PageProps & {
    specDoc: SpecificationDocument;
    specDocSheet: SpecDocSheet;
    specDocItems: SpecDocItem[];
    statuses: { [key: number]: string };
};

type ToggleStatusResponse = {
    newStatusId: number;
};

type Tester = {
    id: number;
    userId: number|null;
    userName: string|null;
    createdAt: string;
};

const Show: React.FC<Props> = ({
    auth,
    specDoc,
    specDocSheet,
    specDocItems,
    statuses,
}) => {
    const [items, setItems] = useState<SpecDocItem[]>(specDocItems);
    const [loading, setLoading] = useState<number | null>(null);
    const [testers, setTesters] = useState<Tester[]>([]);

    useEffect(() => {
        const fetchTesters = async () => {
            try {
                const response = await axios.get(
                    route("testers.index", {
                        projectId: specDoc.projectId,
                        specDocId: specDoc.id,
                        specDocSheetId: specDocSheet.id,
                    })
                );
                const testers = response.data.testers;
                setTesters(testers);

                if (
                    !testers.some(
                        (tester: Tester) => tester.id === auth.user.id
                    )
                ) {
                    if (
                        confirm(
                            "You are not in the tester list. Do you want to join?"
                        )
                    ) {
                        await addTester();
                    }
                }
            } catch (error) {
                console.error("Failed to fetch testers: ", error);
            }
        };
        fetchTesters();
    }, []);

    const addTester = async () => {
        try {
            const response = await axios.post(
                route("testers.store", {
                    projectId: specDoc.projectId,
                    specDocId: specDoc.id,
                    specDocSheetId: specDocSheet.id,
                })
            );

            const newTester = {
                id: response.data.newTesterId,
                userId: auth.user.id,
                userName: auth.user.name,
                createdAt: new Date().toISOString()
            };

            setTesters([...testers, newTester]);
        } catch (error) {
            console.error("Failed to add tester: ", error);
        }
    };

    const removeTester = async (testerId: number) => {
        try {
            await axios.delete(
                route("testers.destroy", {
                    projectId: specDoc.projectId,
                    specDocId: specDoc.id,
                    specDocSheetId: specDocSheet.id,
                    testerId: testerId,
                })
            );
            setTesters(testers.filter((tester) => tester.id !== testerId));
        } catch (error) {
            console.error("Failed to remove tester: ", error);
        }
    };

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

                {/* 別のコンポーネントに分けた方が良いだろうか */}
                <article className="tester">
                    <h3>Tester list</h3>
                    <ul className="tester__list">
                        {testers.map((tester) => (
                            <li key={tester.id}>
                                <span>{tester.userName}</span>
                                <time>{tester.createdAt}</time>
                                {tester.userId === auth.user.id && (
                                    <button
                                        onClick={() => removeTester(tester.id)}
                                    >
                                        Remove
                                    </button>
                                )}
                            </li>
                        ))}
                    </ul>
                </article>

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
