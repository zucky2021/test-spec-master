import InputError from "@/Components/InputError";
import { Department } from "@/types/Department";
import { Project } from "@/types/Project";
import { useForm } from "@inertiajs/react";
import React, { ReactElement } from "react";

type Props = {
  departments: Department[];
  onClose: () => void;
  project: Project;
};

type FormData = {
  id: number;
  departmentId: number;
  name: string;
  summary: string;
};

/**
 * プロジェクト編集component
 * @returns {ReactElement}
 */
const Edit = ({ departments, onClose, project }: Props): ReactElement => {
  const { data, setData, patch, errors, processing } = useForm<FormData>({
    id: project.id,
    departmentId: project.departmentId,
    name: project.name,
    summary: project.summary,
  });

  const handleSubmit = (e: React.FormEvent): void => {
    e.preventDefault();
    patch(
      route("admin.projects.update", {
        projectId: project.id,
      }),
      {
        onSuccess: () => {
          onClose();
        },
      },
    );
  };

  console.log(project);
  console.log(data);

  return (
    <section className="p02">
      <h3 className="font-serif font-bold text-center text-3xl my-4">
        Create project
      </h3>
      <form onSubmit={handleSubmit}>
        <fieldset className="mb-4 text-center">
          <label htmlFor="department" className="mr-4 font-serif">
            Department
          </label>
          <select
            id="department"
            name="departmentId"
            required
            value={data.departmentId}
            className="text-center w-fit rounded-sm font-serif"
            onChange={(e) => setData("departmentId", Number(e.target.value))}
          >
            <option value="">選択してください</option>
            {departments?.map((department) => (
              <option key={department.id} value={department.id}>
                {department.name}
              </option>
            ))}
          </select>
          <InputError message={errors.departmentId} />
        </fieldset>

        <fieldset className="mb-4 text-center">
          <label htmlFor="name" className="mr-4 font-serif">
            Name
          </label>
          <input
            type="text"
            id="name"
            name="name"
            required
            placeholder="ProjectQ"
            className="w-72 rounded-sm"
            value={data.name}
            onChange={(e) => setData("name", e.target.value)}
          />
          <InputError message={errors.name} />
        </fieldset>

        <fieldset className="text-center">
          <label htmlFor="summary" className="block font-serif">
            Summary
          </label>
          <textarea
            id="summary"
            name="summary"
            required
            rows={5}
            placeholder="[React](https://ja.react.dev/)"
            className="rounded-sm w-[90%]"
            value={data.summary}
            onChange={(e) => setData("summary", e.target.value)}
          />
          <InputError message={errors.summary} />
        </fieldset>

        <button
          type="submit"
          className="bg-black text-white font-bold font-serif text-xl py-2 px-4 rounded-sm my-4 mx-auto block cursor-pointer hover:opacity-50"
        >
          {processing ? "Processing" : "Update"}
        </button>
      </form>
    </section>
  );
};

export default Edit;
