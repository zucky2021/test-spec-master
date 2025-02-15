import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";
import { Project } from "@/types/Project";
import { PageProps } from "@/types";
import { Head, Link } from "@inertiajs/react";
import "@scss/pages/project/index.scss";

type Props = PageProps & {
  projects: Project[];
};

const Index: React.FC<Props> = ({ auth, projects }) => {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800 leading-tight">
          Projects
        </h2>
      }
    >
      <Head title="Projects" />

      <ul>
        {projects.map((project) => (
          <li key={project.id}>
            <Link href={`/projects/${project.id}/spec-docs`}>
              <h3>{project.name}</h3>
              <small>{project.summary}</small>
            </Link>
          </li>
        ))}
      </ul>
    </AuthenticatedLayout>
  );
};

export default Index;
