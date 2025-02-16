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
    <AuthenticatedLayout user={auth.user} header={<h1>Projects</h1>}>
      <Head title="Projects" />

      <ul className="project__list">
        {projects.map((project) => (
          <li key={project.id} className="project__list-item">
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
