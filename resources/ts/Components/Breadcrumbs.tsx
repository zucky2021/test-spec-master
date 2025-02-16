import { Breadcrumb } from "@/types/Breadcrumb";
import { Link } from "@inertiajs/react";
import React from "react";
import "@scss/components/breadcrumbs.scss";

type BreadcrumbsProps = {
  breadcrumbs: Breadcrumb[];
};

const Breadcrumbs: React.FC<BreadcrumbsProps> = ({ breadcrumbs }) => {
  return (
    <nav className="breadcrumbs" area-label="Breadcrumb">
      <ol className="breadcrumbs__list">
        {breadcrumbs.map((breadcrumbs, index) => (
          <li key={index} className="breadcrumbs__list-item">
            <Link href={breadcrumbs.url}>{breadcrumbs.name}</Link>
          </li>
        ))}
      </ol>
    </nav>
  );
};

export default Breadcrumbs;
