import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React, { ReactElement } from "react";
import { PageProps } from "@/types";
import { Head, useForm, usePage } from "@inertiajs/react";
import { Project } from "@/types/Project";
import { Flash } from "@/types/Flash";

type Props = PageProps & {
  project: Project;
  flash: Flash;
};

const Index = ({ auth, project }: Props): ReactElement => {
  const { data, setData, post, processing, errors } = useForm({
    title: "",
    summary: "",
  });

  const { flash } = usePage<Props>().props;

  const handleSubmit = (e: React.FormEvent): void => {
    e.preventDefault();
    post(route("specDocs.store", { projectId: project.id }));
  };

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h1 className="text-xl text-center font-serif font-bold">
          Specification documents
        </h1>
      }
    >
      <Head title="Create specification document" />

      <section className="spec-doc-form my-2 mx-auto w-[95%] max-w-screen-lg">
        {flash.error && (
          <p className="font-bold text-center my-2">{flash.error}</p>
        )}

        <form onSubmit={handleSubmit}>
          <div className="mb-4">
            <label
              htmlFor="title"
              className="block text-sm font-medium text-gray-700"
            >
              Title<span className="ml-1 align-middle text-red-500">*</span>
            </label>
            <input
              type="text"
              name="title"
              id="title"
              value={data.title}
              onChange={(e) => setData("title", e.target.value)}
              placeholder="EKI-xx"
              required
              className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            />
            {errors.title && (
              <div className="text-red-500 text-sm">{errors.title}</div>
            )}
          </div>

          <div className="mb-4">
            <label
              htmlFor="summary"
              className="block text-sm font-medium text-gray-700"
            >
              Summary
            </label>
            <textarea
              name="summary"
              id="summary"
              value={data.summary}
              onChange={(e) => setData("summary", e.target.value)}
              placeholder="https://backlog.com/ja/"
              className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              rows={5}
            ></textarea>
            {errors.summary && (
              <div className="text-red-500 text-sm">{errors.summary}</div>
            )}
          </div>

          <div className="flex justify-end">
            <button
              type="submit"
              className={`bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded {processing ? 'Processing...' : 'Create'}`}
              disabled={processing}
            >
              {processing ? "Processing..." : "Create"}
            </button>
          </div>
        </form>
      </section>
    </AuthenticatedLayout>
  );
};

export default Index;
