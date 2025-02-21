import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { PageProps } from "@/types";
import { Head } from "@inertiajs/react";
import { ReactElement } from "react";

const Index = ({ auth }: PageProps): ReactElement => {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h1 className="text-xl text-center font-serif font-bold">
          Admin projects
        </h1>
      }
    >
      <Head title="Admin projects" />
    </AuthenticatedLayout>
  );
};

export default Index;
