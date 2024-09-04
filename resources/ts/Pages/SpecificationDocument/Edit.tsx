import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";
import { PageProps } from "@/types";
import { Head, Link, useForm, usePage } from "@inertiajs/react";
import "@scss/pages/specification_document/index.scss";
import { Project } from "@/types/Project";
import { Flash } from "@/types/Flash";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import { ExecutionEnvironment } from "@/types/ExecutionEnvironment";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import SpecDocSheetManager from "@/Components/SpecificationDocument/SpecDocSheetManager";

type Props = PageProps & {
    project: Project;
    specificationDocument: SpecificationDocument;
    executionEnvironments: ExecutionEnvironment[];
    specDocSheets: SpecDocSheet[];
    flash: Flash;
};

const Index: React.FC<Props> = ({
    auth,
    project,
    specificationDocument,
    executionEnvironments,
    specDocSheets,
}) => {
    const { data, setData, put, processing, errors } = useForm({
        title: specificationDocument?.title || "",
        summary: specificationDocument?.summary || "",
    });

    const { flash } = usePage<Props>().props;

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(
            route("specDocs.update", {
                projectId: project.id,
                specDocId: specificationDocument.id,
            })
        );
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Edit specification document
                </h2>
            }
        >
            <Head title="Edit specification document" />

            <section className="spec-doc-form">
                {flash.error && (
                    <p className="spec-doc-form__flash">{flash.error}</p>
                )}
                {flash.success && (
                    <p className="spec-doc-form__flash">{flash.success}</p>
                )}

                <Link
                    href={route("specDocSheets.index", {
                        projectId: project.id,
                        specDocId: specificationDocument.id,
                    })}
                >
                    シート一覧へ
                </Link>

                <time className="spec-doc-form__updated-at" dateTime={specificationDocument.updatedAt}>
                    Updated at: {specificationDocument.updatedAt}
                </time>
                <form onSubmit={handleSubmit}>
                    <div className="mb-4">
                        <label
                            htmlFor="title"
                            className="block text-sm font-medium text-gray-700"
                        >
                            Title
                        </label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            value={data.title}
                            onChange={(e) => setData("title", e.target.value)}
                            placeholder="EKI-xx"
                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        {errors.title && (
                            <div className="text-red-500 text-sm">
                                {errors.title}
                            </div>
                        )}
                    </div>

                    <div className="mb-4">
                        <label
                            htmlFor="summary"
                            className="block text-sm font-medium text-gray-700"
                        >
                            Summary
                        </label>
                        <textarea
                            name="summary"
                            id="summary"
                            value={data.summary}
                            onChange={(e) => setData("summary", e.target.value)}
                            placeholder="https://backlog.com/ja/"
                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            rows={5}
                        ></textarea>
                        {errors.summary && (
                            <div className="text-red-500 text-sm">
                                {errors.summary}
                            </div>
                        )}
                    </div>

                    <div className="flex justify-end">
                        <button
                            type="submit"
                            className={`bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded ${processing ? 'Processing...' : 'Create'}`}
                            disabled={processing}
                        >
                            {processing ? "Processing..." : "Update"}
                        </button>
                    </div>
                </form>
            </section>

            <SpecDocSheetManager
                specificationDocument={specificationDocument}
                executionEnvironments={executionEnvironments}
                specDocSheets={specDocSheets}
            />
        </AuthenticatedLayout>
    );
};

export default Index;
