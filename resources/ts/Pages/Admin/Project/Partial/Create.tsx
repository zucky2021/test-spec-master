import InputError from "@/Components/InputError";
import { Department } from "@/types/Department";
import { useForm } from "@inertiajs/react";
import React, { ReactElement } from "react";

type Props = {
  departments: Department[];
  onClose: () => void;
};

type FormData = {
  departmentId: number | null;
  name: string;
  summary: string;
};

/**
 * プロジェクト作成component
 * @returns {ReactElement}
 */
const Create = ({ departments, onClose }: Props): ReactElement => {
  const { data, setData, post, errors, processing } = useForm<FormData>({
    departmentId: null,
    name: "",
    summary: "",
  });

  const handleSubmit = (e: React.FormEvent): void => {
    e.preventDefault();
    post(route("admin.projects.store", data), {
      onSuccess: () => {
        onClose();
      },
      onError: (errors) => {
        console.error(errors);
      },
    });
  };

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
            aria-required="true"
            aria-invalid={errors.departmentId ? "true" : "false"}
            className="text-center w-fit rounded-sm font-serif"
            onChange={(e) => setData("departmentId", Number(e.target.value))}
          >
            <option value="">Please select</option>
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
            aria-required="true"
            placeholder="ProjectQ"
            className="w-72 rounded-sm"
            onChange={(e) => setData("name", e.target.value)}
            aria-invalid={errors.name ? "true" : "false"}
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
            aria-required="true"
            rows={5}
            placeholder="[React](https://ja.react.dev/)"
            className="rounded-sm w-[90%]"
            onChange={(e) => setData("summary", e.target.value)}
            aria-invalid={errors.summary ? "true" : "false"}
          />
          <InputError message={errors.summary} />
        </fieldset>

        <button
          type="submit"
          className="bg-black text-white font-bold font-serif text-xl py-2 px-4 rounded-sm my-4 mx-auto block cursor-pointer hover:opacity-50"
          disabled={processing}
          aria-disabled={processing}
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
            "Save"
          )}
        </button>
      </form>
    </section>
  );
};

export default Create;
