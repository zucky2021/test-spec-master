import React, { useEffect, useState } from "react";
import { Link, useForm } from "@inertiajs/react";
import { SpecDocSheet } from "@/types/SpecDocSheet";
import { ExecutionEnvironment } from "@/types/ExecutionEnvironment";
import { SpecificationDocument } from "@/types/SpecificationDocument";
import Modal from "@/Components/Modal";
import Dropdown from "../Dropdown";
import axios from "axios";

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
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [action, setAction] = useState<"add" | "copy">("add");

    const { data, setData } = useForm({
        exec_env_id: 0,
    });

    const availableEnvironments = executionEnvironments.filter(
        (env) => !sheets.some((sheet) => sheet.execEnvId === env.id)
    );

    const handleAddSheet = async (envId: number) => {
        try {
            const response = await axios.post<AddSheetResponse>(
                route("specDocSheets.store", {
                    projectId: specificationDocument.projectId,
                    specDocId: specificationDocument.id,
                }),
                data
            );
            const { message, newSpecDocSheetId } = response.data;

            const execEnv = executionEnvironments.find(
                (env) => env.id === envId
            );
            const execEnvName = execEnv ? execEnv.name : "";

            if (newSpecDocSheetId) {
                const newSheet: SpecDocSheet = {
                    id: newSpecDocSheetId,
                    specDocId: specificationDocument.id,
                    execEnvId: envId,
                    statusId: 0,
                    updatedAt: "",
                    execEnvName: execEnvName,
                };
                setSheets([...sheets, newSheet]);
            }
            alert(message);
        } catch (error) {
            console.error(error);
        } finally {
            setIsModalOpen(false);
        }
    };

    useEffect(() => {
        if (data.exec_env_id !== 0) {
            handleAddSheet(data.exec_env_id);
        }
    }, [data.exec_env_id]);

    const handleCopySheet = (sheetId: number) => {};

    const handleRemoveSheet = async (sheetId: number) => {
        try {
            const response = await axios.delete<DeleteSheetResponse>(
                route("specDocSheets.destroy", {
                    projectId: specificationDocument.projectId,
                    specDocId: specificationDocument.id,
                    specDocSheetId: sheetId,
                })
            );

            setSheets(sheets.filter((sheet) => sheet.id !== sheetId));
            alert(response.data.message);
        } catch (error) {
            console.error("Failed to delete sheet: ", error);
        }
    };

    const handleDisplayDialog = (
        action: "add" | "copy",
        sheetId: number | null = null
    ) => {
        setAction(action);
        if (action === "copy" && sheetId !== null) {
            handleCopySheet(sheetId);
        } else {
            setIsModalOpen(true);
        }
    };

    return (
        <section className="exec-env-form">
            <ul>
                {sheets.map((sheet) => (
                    <li key={sheet.execEnvId}>
                        {sheet.execEnvName}

                        <Dropdown>
                            <Dropdown.Trigger>
                                <button>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        className="h-4 w-4 text-gray-400"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                            </Dropdown.Trigger>
                            <Dropdown.Content>
                                <Link
                                    href={route("specDocSheets.edit", {
                                        projectId:
                                            specificationDocument.projectId,
                                        specDocId: specificationDocument.id,
                                        specDocSheetId: sheet.id,
                                    })}
                                    className="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out"
                                >
                                    Edit
                                </Link>
                                <button
                                    className="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out"
                                    // onClick={() => setEditing(true)}
                                >
                                    Edit env
                                </button>
                                <button
                                    className="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out"
                                    onClick={() => handleRemoveSheet(sheet.id)}
                                >
                                    Delete
                                </button>
                            </Dropdown.Content>
                        </Dropdown>
                    </li>
                ))}
            </ul>

            <button onClick={() => handleDisplayDialog("add")}>
                Add execute environment
            </button>

            <Modal
                show={isModalOpen}
                onClose={() => setIsModalOpen(false)}
                maxWidth="md"
            >
                <form>
                    <ul>
                        {availableEnvironments.map((env) => (
                            <li
                                key={env.id}
                                onClick={() => setData("exec_env_id", env.id)}
                                className="cursor-pointer"
                            >
                                {env.name}
                            </li>
                        ))}
                    </ul>
                </form>
            </Modal>
        </section>
    );
};

export default SpecDocSheetManager;
