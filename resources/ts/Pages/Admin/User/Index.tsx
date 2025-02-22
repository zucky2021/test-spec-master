import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { PageProps } from "@/types";
import { Head } from "@inertiajs/react";
import { ReactElement } from "react";
import UsersPartial from "./Partial/UsersPartial";

const Index = ({ auth }: PageProps): ReactElement => {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h1 className="text-xl text-center font-serif font-bold">Users</h1>
      }
    >
      <Head title="Users" />

      <UsersPartial />
    </AuthenticatedLayout>
  );
};

export default Index;
