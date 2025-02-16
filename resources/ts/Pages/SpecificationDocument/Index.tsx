import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React, { useEffect, useState } from "react";
import { PageProps } from "@/types";
import { Head, Link, usePage } from "@inertiajs/react";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import "@scss/pages/specification_document/index.scss";
import { Project } from "@/types/Project";
import { Flash } from "@/types/Flash";
import Breadcrumbs from "@/Components/Breadcrumbs";
import { Breadcrumb } from "@/types/Breadcrumb";
import SlideAlert from "@/Components/SlideAlert";

type Props = PageProps & {
  project: Project;
  specificationDocuments: SpecificationDocument[];
  breadcrumbs: Breadcrumb[];
  flash: Flash;
};

const Index: React.FC<Props> = ({
  auth,
  project,
  specificationDocuments,
  breadcrumbs,
}) => {
  const { flash } = usePage<Props>().props;
  const [isShowAlert, setIsShowAlert] = useState(!!flash.success);

  useEffect(() => {
    const handleIsShowAlert = () => {
      setIsShowAlert(true);
      const timer = setTimeout(() => {
        setIsShowAlert(false);
      }, 5000);

      return () => clearTimeout(timer);
    };

    if (flash.success) {
      handleIsShowAlert();
    }
  }, []);

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={<h1>Specification documents</h1>}
    >
      <Head title="Specification documents" />

      <Breadcrumbs breadcrumbs={breadcrumbs} />

      <section className="specification-document">
        <Link
          href={`/projects/${project.id}/spec-docs/create`}
          className="specification-document__create-btn"
        >
          Create
        </Link>

        <SlideAlert isShow={isShowAlert}>
          <p className="flash-msg">{flash?.success}</p>
        </SlideAlert>

        <ul className="specification-document__list">
          {specificationDocuments.length > 0 ? (
            specificationDocuments.map((specDoc) => (
              <li
                key={specDoc.id}
                className="specification-document__list-item"
              >
                <Link
                  href={`/projects/${specDoc.projectId}/spec-docs/${specDoc.id}/sheets`}
                >
                  <h3>{specDoc.title}</h3>
                </Link>
              </li>
            ))
          ) : (
            <li className="specification-document__list-not-exists">
              Specification document does not exist.
            </li>
          )}
        </ul>
      </section>
    </AuthenticatedLayout>
  );
};

export default Index;
