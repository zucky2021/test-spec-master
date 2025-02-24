import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { PageProps } from "@/types";
import { Project } from "@/types/Project";
import { Head, Link, useForm } from "@inertiajs/react";
import { ReactElement, useEffect, useState } from "react";
import Create from "./Partial/Create";
import Modal from "@/Components/Modal";
import { Department } from "@/types/Department";
import { Flash } from "@/types/Flash";
import SlideAlert from "@/Components/SlideAlert";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import Edit from "./Partial/Edit";

type Props = PageProps & {
  projects: Project[];
  departments: Department[];
  flash: Flash;
};

const Index = ({ auth, projects, departments, flash }: Props): ReactElement => {
  const [showCreateModal, setShowCreateModal] = useState(false);
  const [isShowAlert, setIsShowAlert] = useState(false);
  const [showEditModal, setShowEditModal] = useState(false);
  const [editProject, setEditProject] = useState<Project | null>(null);

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

  const handleEdit = (project: Project): void => {
    setEditProject(project);
    setShowEditModal(true);
  };

  const { delete: destroy, processing } = useForm();
  const handleDelete = (id: number): void => {
    if (!confirm("本当に削除しますか？")) return;

    console.log(id);

    destroy(
      route("admin.projects.destroy", {
        projectId: id,
      }),
    );
  };

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
          onClick={() => setShowCreateModal(true)}
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
              className="shadow-sm rounded-sm my-2 p-2 font-bold flex justify-between"
            >
              <details>
                <summary className="cursor-pointer hover:opacity-50">
                  {project.name}
                </summary>
                <ReactMarkdown
                  remarkPlugins={[remarkGfm]}
                  className="markdown"
                  components={{
                    a: ({ href, children }) => (
                      <a href={href} target="_blank">
                        {children}
                      </a>
                    ),
                  }}
                >
                  {project.summary}
                </ReactMarkdown>
              </details>
              <div className="flex">
                <button
                  onClick={() => {
                    handleEdit(project);
                  }}
                  className="bg-blue-500 text-white p-1 min-w-14 h-fit block rounded-sm hover:opacity-50"
                >
                  Edit
                </button>
                <button
                  onClick={() => {
                    handleDelete(project.id);
                  }}
                  className={`bg-red-500 text-white ml-2 p-1 min-w-14 h-fit block rounded-sm hover:opacity-50 ${processing ? "opacity-50" : ""}`}
                  disabled={processing}
                  aria-busy={processing}
                >
                  {processing ? (
                    <>
                      <span
                        className="inline-block animate-spin mr-2"
                        aria-label="読み込み中"
                      >
                        ↻
                      </span>
                      Processing
                    </>
                  ) : (
                    "Delete"
                  )}
                </button>
              </div>
            </li>
          ))}
        </ul>
      </section>

      <Modal show={showCreateModal} onClose={() => setShowCreateModal(false)}>
        <Create
          departments={departments}
          onClose={() => setShowCreateModal(false)}
        />
      </Modal>

      {editProject && (
        <Modal show={showEditModal} onClose={() => setShowEditModal(false)}>
          <Edit
            departments={departments}
            onClose={() => setShowEditModal(false)}
            project={editProject}
          />
        </Modal>
      )}
    </AuthenticatedLayout>
  );
};

export default Index;
