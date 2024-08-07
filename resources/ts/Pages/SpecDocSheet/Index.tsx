import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";
import { PageProps } from "@/types";
import { Head, Link } from "@inertiajs/react";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import "@scss/pages/specification_document/index.scss";
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
            <Head title="Specification document sheet" />

            <ul>
                {specDocSheets.length > 0 ? (
                    specDocSheets.map((specDocSheet) => (
                        <li key={specDocSheet.id}>
                            <Link href={`/project/${specDocSheet.specDocId}/spec-doc/${specDocSheet.id}`}>
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
