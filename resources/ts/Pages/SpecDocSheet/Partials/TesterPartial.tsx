import { User } from "@/types";
import axios from "axios";
import { ReactElement, useCallback, useEffect, useState } from "react";

type TesterProps = {
  authUser: User;
  specDoc: { projectId: number; id: number };
  specDocSheetId: number;
};

type Tester = {
  id: number;
  userName: string;
  createdAt: string;
  userId: number | null;
};

type AddTesterResponse = {
  newTester: {
    id: number;
    userName: string;
    createdAt: string;
    userId: number | null;
  };
};

const TesterPartial = ({
  authUser,
  specDoc,
  specDocSheetId,
}: TesterProps): ReactElement => {
  const [testers, setTesters] = useState<Tester[]>([]);

  const fetchTesters = useCallback(async () => {
    try {
      const response = await axios.get(
        route("testers.index", {
          projectId: specDoc.projectId,
          specDocId: specDoc.id,
          specDocSheetId: specDocSheetId,
        }),
      );
      setTesters(response.data.testers);

      if (
        !response.data.testers.some(
          (tester: Tester) => tester.userId === authUser.id,
        )
      ) {
        if (confirm("You are not in the tester list. Do you want to join?")) {
          await addTester();
        }
      }
    } catch (error) {
      console.error("Failed to fetch testers: ", error);
    }
  }, [specDoc.projectId, specDoc.id, specDocSheetId, authUser.id]);

  useEffect(() => {
    fetchTesters();
  }, []);

  const addTester = async (): Promise<void> => {
    try {
      const response = await axios.post<AddTesterResponse>(
        route("testers.store", {
          projectId: specDoc.projectId,
          specDocId: specDoc.id,
          specDocSheetId: specDocSheetId,
        }),
      );
      const newTester: Tester = {
        id: response.data.newTester.id,
        userName: response.data.newTester.userName,
        createdAt: response.data.newTester.createdAt,
        userId: response.data.newTester.userId,
      };
      setTesters([...testers, newTester]);
    } catch (error) {
      console.error("Failed to add tester: ", error);
    }
  };

  const removeTester = async (testerId: number): Promise<void> => {
    if (!confirm("本当に削除しますか？")) return;

    try {
      await axios.delete(
        route("testers.destroy", {
          projectId: specDoc.projectId,
          specDocId: specDoc.id,
          specDocSheetId: specDocSheetId,
          testerId: testerId,
        }),
      );
      setTesters(testers.filter((tester) => tester.id !== testerId));
    } catch (error) {
      console.error("Failed to remove tester: ", error);
    }
  };

  return (
    <section className="p-2 rounded-md shadow-md my-2 w-96 mx-auto">
      <h3 className="text-lg text-center font-bold font-serif">Tester list</h3>
      <ul className="mx-auto max-w-fit">
        {testers.map((tester) => (
          <li key={tester.id} className="p-2 shadow-md my-1 rounded-md">
            <span className="font-bold">{tester.userName}</span>
            <time className="text-green-500 mx-2 text-sm">
              {tester.createdAt}
            </time>
            {tester.userId === authUser.id && (
              <button
                onClick={() => removeTester(tester.id)}
                className="bg-red-500 text-white rounded-md p-1"
              >
                Remove
              </button>
            )}
          </li>
        ))}
      </ul>
    </section>
  );
};

export default TesterPartial;
