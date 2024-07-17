import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";
import { PageProps } from "@/types";
import { Head, Link } from "@inertiajs/react";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import "@scss/pages/specification_document/index.scss";

type Props = PageProps & {
    specificationDocuments: SpecificationDocument[];
};

const Index: React.FC<Props> = ({ auth, specificationDocuments }) => {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Projects
                </h2>
            }
        >
            <Head title="Specification documents" />

            <ul>
                {specificationDocuments.map((specDoc) => (
                    <li key={specDoc.id}>
                        <Link href={`/project/${specDoc.id}/spec-doc`}>
                            <h3>{specDoc.title}</h3>
                            <small>{specDoc.summary}</small>
                        </Link>
                    </li>
                ))}
            </ul>
        </AuthenticatedLayout>
    );
};

export default Index;
