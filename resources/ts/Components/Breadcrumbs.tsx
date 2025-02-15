import { Breadcrumb } from "@/types/Breadcrumb";
import { Link } from "@inertiajs/react";
import React from "react";
import "@scss/components/breadcrumbs.scss";

type BreadcrumbsProps = {
  breadcrumbs: Breadcrumb[];
};

const Breadcrumbs: React.FC<BreadcrumbsProps> = ({ breadcrumbs }) => {
  return (
    <nav area-label="Breadcrumb">
      <ol className="breadcrumbs">
        {breadcrumbs.map((breadcrumbs, index) => (
          <li key={index} className="breadcrumbs__item">
            <Link href={breadcrumbs.url}>{breadcrumbs.name}</Link>
          </li>
        ))}
      </ol>
    </nav>
  );
};

export default Breadcrumbs;
