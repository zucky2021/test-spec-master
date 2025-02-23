import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { PageProps } from "@/types";
import { Project } from "@/types/Project";
import { Head, Link } from "@inertiajs/react";
import { ReactElement, useEffect, useState } from "react";
import Create from "./Partial/Create";
import Modal from "@/Components/Modal";
import { Department } from "@/types/Department";
import { Flash } from "@/types/Flash";
import SlideAlert from "@/Components/SlideAlert";

type Props = PageProps & {
  projects: Project[];
  departments: Department[];
  flash: Flash;
};

const Index = ({ auth, projects, departments, flash }: Props): ReactElement => {
  const [showCreateModel, setShowCreateModel] = useState(false);
  const [isShowAlert, setIsShowAlert] = useState(false);

  useEffect(() => {
    const handleIsShowAlert = () => {
      setIsShowAlert(true);
      const timer = setTimeout(() => {
        setIsShowAlert(false);
      }, 5000);

      return (): void => clearTimeout(timer);
    };

    if (flash.error) {
      handleIsShowAlert();
    }
  }, []);

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h1 className="text-xl text-center font-serif font-bold">
          Edit projects
        </h1>
      }
    >
      <Head title="Admin projects" />

      <SlideAlert isShow={isShowAlert}>
        <p className="text-red-500">{flash.error}</p>
      </SlideAlert>

      <div className="flex items-center justify-between w-[95%] max-w-lg mx-auto mb-4">
        <Link
          href={route("admin.dashboard")}
          className="p-2 w-24 bg-gray-500 text-white text-center text-lg rounded-3xl hover:opacity-50"
        >
          Back
        </Link>
        <button
          onClick={() => setShowCreateModel(true)}
          className="p-2 w-24 bg-green-500 text-white text-center text-lg rounded-3xl hover:opacity-50"
        >
          Create
        </button>
      </div>

      <section className="w-[95%] max-w-screen-lg mx-auto p-2 bg-white rounded-md shadow-md">
        <ul>
          {projects?.map((project) => (
            <li
              key={project.id}
              className="shadow-sm rounded-sm my-2 p-2 font-bold"
            >
              <Link
                href={route("admin.projects.edit", { projectId: project.id })}
              >
                {project.name}
              </Link>
            </li>
          ))}
        </ul>
      </section>

      <Modal show={showCreateModel} onClose={() => setShowCreateModel(false)}>
        <Create
          departments={departments}
          onClose={() => setShowCreateModel(false)}
        />
      </Modal>
    </AuthenticatedLayout>
  );
};

export default Index;
