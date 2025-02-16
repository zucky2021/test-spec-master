import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";
import { PageProps } from "@/types";
import { Head, Link, useForm, usePage } from "@inertiajs/react";
import { Project } from "@/types/Project";
import { Flash } from "@/types/Flash";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import { ExecutionEnvironment } from "@/types/ExecutionEnvironment";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import SpecDocSheetManager from "./Partials/SpecDocSheetManager";
import DangerButton from "@/Components/DangerButton";
import "@scss/pages/specification_document/edit.scss";
import PrimaryButton from "@/Components/PrimaryButton";
import { Transition } from "@headlessui/react";

type Props = PageProps & {
  project: Project;
  specificationDocument: SpecificationDocument;
  executionEnvironments: ExecutionEnvironment[];
  specDocSheets: SpecDocSheet[];
  flash: Flash;
};

const Index: React.FC<Props> = ({
  auth,
  project,
  specificationDocument,
  executionEnvironments,
  specDocSheets,
}) => {
  const { data, setData, put, patch, processing, errors, recentlySuccessful } =
    useForm({
      title: specificationDocument?.title || "",
      summary: specificationDocument?.summary || "",
    });

  const { flash } = usePage<Props>().props;

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    put(
      route("specDocs.update", {
        projectId: project.id,
        specDocId: specificationDocument.id,
      }),
    );
  };

  /**
   * 論理削除
   * @param e フォームイベント
   */
  const handleDelete = (e: React.FormEvent) => {
    e.preventDefault();
    if (confirm("本当に削除しますか？")) {
      patch(
        route("specDocs.softDelete", {
          projectId: project.id,
          specDocId: specificationDocument.id,
        }),
      );
    }
  };

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={<h1>Edit specification document</h1>}
    >
      <Head title="Edit specification document" />

      <section className="spec-doc-edit">
        <Link
          href={route("specDocSheets.index", {
            projectId: project.id,
            specDocId: specificationDocument.id,
          })}
          className="spec-doc-edit__back-btn"
        >
          Back
        </Link>

        <p className="spec-doc-edit__updated-at">
          Updated at:
          <time dateTime={specificationDocument.updatedAt}>
            {specificationDocument.updatedAt}
          </time>
        </p>

        <form onSubmit={handleSubmit} className="spec-doc-edit__form">
          <fieldset>
            <label htmlFor="title">Title</label>
            <input
              type="text"
              name="title"
              id="title"
              value={data.title}
              onChange={(e) => setData("title", e.target.value)}
              placeholder="EKI-xx"
            />
            {errors.title && (
              <p className="spec-doc-edit__form-err">{errors.title}</p>
            )}
          </fieldset>

          <fieldset>
            <label htmlFor="summary">Summary</label>
            <textarea
              name="summary"
              id="summary"
              value={data.summary}
              onChange={(e) => setData("summary", e.target.value)}
              placeholder="https://backlog.com/ja/"
              rows={5}
            ></textarea>
            {errors.summary && (
              <div className="spec-doc-edit__form-err">{errors.summary}</div>
            )}
          </fieldset>

          {/* FIXME:表示非表示切り替えるトグルスイッチを追加 */}

          <div className="spec-doc-edit__form-btns">
            <PrimaryButton disabled={processing}>Save</PrimaryButton>
            <Transition
              show={recentlySuccessful && !flash.error}
              enter="transition ease-in-out"
              enterFrom="opacity-0"
              leave="transition ease-in-out"
              leaveTo="opacity-0"
            >
              <p className="text-sm text-gray-600">Saved.</p>
            </Transition>

            <Transition
              show={recentlySuccessful && !!flash.error}
              enter="transition ease-in-out"
              enterFrom="opacity-0"
              leave="transition ease-in-out"
              leaveTo="opacity-0"
            >
              <p className="spec-doc-edit__form-flash-err">{flash.error}</p>
            </Transition>

            <DangerButton onClick={handleDelete}>Delete</DangerButton>
          </div>
        </form>
      </section>

      <SpecDocSheetManager
        specificationDocument={specificationDocument}
        executionEnvironments={executionEnvironments}
        specDocSheets={specDocSheets}
      />
    </AuthenticatedLayout>
  );
};

export default Index;
