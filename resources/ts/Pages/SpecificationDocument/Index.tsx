import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";
import { PageProps } from "@/types";
import { Head, Link, useForm, usePage } from "@inertiajs/react";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import "@scss/pages/specification_document/index.scss";
import { Project } from "@/types/Project";
import { Flash } from "@/types/Flash";

type Props = PageProps & {
    project: Project;
    specificationDocuments: SpecificationDocument[];
    flash: Flash;
};

const Index: React.FC<Props> = ({ auth, project, specificationDocuments }) => {
    const { flash } = usePage<Props>().props;

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Specification documents
                </h2>
            }
        >
            <Head title="Specification documents" />

            <ul>
                {specificationDocuments.length > 0 ? (
                    specificationDocuments.map((specDoc) => (
                        <li key={specDoc.id}>
                            <Link href={`/projects/${specDoc.projectId}/spec-docs/${specDoc.id}/sheets`}>
                                <h3>{specDoc.title}</h3>
                                <small>{specDoc.summary}</small>
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
