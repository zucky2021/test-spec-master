import React, { useState } from "react";
import { Link } from "@inertiajs/react";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import { ExecutionEnvironment } from "@/types/ExecutionEnvironment";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import axios from "axios";
import "@scss/pages/specification_document/partials/env.scss";

type Props = {
  specificationDocument: SpecificationDocument;
  executionEnvironments: ExecutionEnvironment[];
  specDocSheets: SpecDocSheet[];
};

type DeleteSheetResponse = {
  message: string;
};

type AddSheetResponse = {
  message: string;
  newSpecDocSheetId?: number;
};

const SpecDocSheetManager: React.FC<Props> = ({
  specificationDocument,
  executionEnvironments,
  specDocSheets,
}) => {
  const [sheets, setSheets] = useState(specDocSheets);
  const [selectedEnvId, setSelectedEnvId] = useState(0);

  const handleSubmit = (e: React.FormEvent): void => {
    e.preventDefault();
    if (selectedEnvId !== 0) {
      handleAddSheet(selectedEnvId);
    }
  };

  const availableEnvironments = executionEnvironments.filter(
    (env) => !sheets.some((sheet) => sheet.execEnvId === env.id),
  );

  const handleAddSheet = async (envId: number): Promise<void> => {
    try {
      const response = await axios.post<AddSheetResponse>(
        route("specDocSheets.store", {
          projectId: specificationDocument.projectId,
          specDocId: specificationDocument.id,
        }),
        { exec_env_id: envId },
      );
      const { newSpecDocSheetId } = response.data;

      const newExecEnv = executionEnvironments.find((env) => env.id === envId);
      const newExecEnvName = newExecEnv ? newExecEnv.name : "";

      if (newSpecDocSheetId) {
        const newSheet: SpecDocSheet = {
          id: newSpecDocSheetId,
          specDocId: specificationDocument.id,
          execEnvId: envId,
          statusId: 0,
          updatedAt: "",
          execEnvName: newExecEnvName,
        };
        setSheets([...sheets, newSheet]);
      }
    } catch (error) {
      console.error(error);
    }
  };

  const handleRemoveSheet = async (sheetId: number): Promise<void> => {
    if (!confirm("本当に削除しますか？")) return;

    try {
      await axios.delete<DeleteSheetResponse>(
        route("specDocSheets.destroy", {
          projectId: specificationDocument.projectId,
          specDocId: specificationDocument.id,
          specDocSheetId: sheetId,
        }),
      );

      setSheets(sheets.filter((sheet) => sheet.id !== sheetId));
    } catch (error) {
      console.error("Failed to delete sheet: ", error);
    }
  };

  return (
    <section className="exec-env-edit">
      <h2>Edit execute environments</h2>

      <ul className="exec-env-edit__list">
        {sheets.map((sheet) => (
          <li key={sheet.execEnvId} className="exec-env-edit__list-item">
            {sheet.execEnvName}

            <div className="exec-env-edit__list-links">
              <Link
                href={route("specDocSheets.edit", {
                  projectId: specificationDocument.projectId,
                  specDocId: specificationDocument.id,
                  specDocSheetId: sheet.id,
                })}
                className="exec-env-edit__list-edit-btn"
              >
                Edit
              </Link>

              {/* FIXME:複製処理実装
              <button
                className="exec-env-edit__list-copy-btn"
                onClick={handleCopySheet}
              >
                Copy
              </button> */}

              <button
                className="exec-env-edit__list-delete-btn"
                onClick={() => handleRemoveSheet(sheet.id)}
              >
                Delete
              </button>
            </div>
          </li>
        ))}
      </ul>

      <form onSubmit={handleSubmit} className="exec-env-edit__form">
        <select
          id="envSelect"
          onChange={(e) => setSelectedEnvId(Number(e.target.value))}
        >
          <option value="0">選択してください</option>
          {availableEnvironments.map((env) => (
            <option key={env.id} value={env.id}>
              {env.name}
            </option>
          ))}
        </select>

        <button aria-label="シートを追加" type="submit">
          Add
        </button>
      </form>
    </section>
  );
};

export default SpecDocSheetManager;
