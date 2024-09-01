import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import { PageProps } from "@/types";
import { Head, Link } from "@inertiajs/react";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import "@scss/pages/specification_document/index.scss";
import { SpecificationDocument } from "@/types/SpecificationDocument";

type Props = PageProps & {
    specDoc: SpecificationDocument;
    specDocSheet: SpecDocSheet;
};

const Index: React.FC<Props> = ({ auth, specDoc, specDocSheet }) => {
    console.dir(specDoc, specDocSheet);
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Specification document sheet edit
                </h2>
            }
        >
            <Head title="Specification document sheet edit" />

            <section>
                <div>
                    <h3>{specDoc.title}</h3>
                    <h4>{specDocSheet.execEnvName}</h4>
                    <details>
                        <summary>Summary</summary>
                        <ReactMarkdown remarkPlugins={[remarkGfm]} className="markdown">
                            {specDoc.summary}
                        </ReactMarkdown>
                    </details>
                </div>


            </section>
        </AuthenticatedLayout>
    );
};

export default Index;
