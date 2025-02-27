import { User } from "@/types/User";
import axios from "axios";
import { ReactElement, useCallback, useEffect, useState } from "react";

type UserResponse = {
  users: User[];
};

type Props = {
  loginUserId: number;
};

const UsersPartial = ({ loginUserId }: Props): ReactElement => {
  const [users, setUsers] = useState<User[]>([]);
  const [isLoading, setIsLoading] = useState(false);

  useEffect(() => {
    const fetchUsers = async (): Promise<void> => {
      setIsLoading(true);
      try {
        const response = await axios.get<UserResponse>(
          route("admin.users.ajax"),
        );

        setUsers(response.data.users);
      } catch (error) {
        console.error("Failed to fetch users: ", error);
      } finally {
        setIsLoading(false);
      }
    };

    fetchUsers();
  }, []);

  /**
   * 管理者権限を更新
   */
  const toggleAdmin = useCallback(
    async (id: number, isAdmin: boolean): Promise<void> => {
      try {
        await axios.patch(
          route("admin.users.update.ajax", {
            userId: id,
            isAdmin: !isAdmin,
          }),
        );

        setUsers(
          users.map((user) =>
            user.id === id ? { ...user, isAdmin: !user.isAdmin } : user,
          ),
        );
      } catch (error) {
        console.error("Failed to update admin status:", error);
      }
    },
    [users],
  );

  return (
    <section className="w-[95%] max-w-screen-lg mx-auto my-2 p-2 bg-white rounded-md shadow-md">
      <h2 className="text-center text-lg font-serif">Edit admin role</h2>

      <ul className="w-full">
        {isLoading ? (
          <p role="status">Loading...</p>
        ) : (
          users?.map((user) => (
            <li
              key={user.id}
              className="w-full p-2 rounded-sm shadow-sm flex items-center justify-between"
            >
              <p className="font-bold">
                {user.name}
                {loginUserId === user.id && (
                  <strong className="ml-2 text-xs text-gray-500 border-gray-500 border rounded-sm p-0.5">
                    Current
                  </strong>
                )}
              </p>

              <label
                className={`${loginUserId === user.id ? "pointer-events-none" : "cursor-pointer"} relative inline-flex items-center w-32`}
              >
                <input
                  type="checkbox"
                  value=""
                  className="sr-only peer"
                  checked={user.isAdmin}
                  onChange={() => toggleAdmin(user.id, user.isAdmin)}
                  aria-label={`${user.isAdmin ? "無効" : "有効"}にする`}
                  disabled={loginUserId === user.id}
                />
                <div className="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span className="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                  {user.isAdmin ? "Admin" : "Not admin"}
                </span>
              </label>
            </li>
          ))
        )}
      </ul>
    </section>
  );
};

export default UsersPartial;
