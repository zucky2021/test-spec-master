import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";
import { PageProps } from "@/types";
import { Head, Link, useForm } from "@inertiajs/react";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import "@scss/pages/specification_document/index.scss";
import { Project } from "@/types/Project";

type Props = PageProps & {
    project: Project;
    specificationDocuments: SpecificationDocument[];
};

const Index: React.FC<Props> = ({ auth, project, specificationDocuments }) => {
    const { data, setData, post, processing, errors } = useForm({
        title: "",
        summary: "",
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route("specDocs.store", { projectId: project.id }));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Specification documents
                </h2>
            }
        >
            <Head title="Create specification document" />

            <section className="spec-doc">
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
                            onChange={e => setData("title", e.target.value)}
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
                            className="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
                            disabled={processing}
                        >
                            Create
                        </button>
                    </div>
                </form>
            </section>
        </AuthenticatedLayout>
    );
};

export default Index;
