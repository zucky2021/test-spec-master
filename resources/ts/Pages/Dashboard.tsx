import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { PageProps } from "@/types";
import React from "react";
import "@scss/pages/dashboard.scss";

type Props = PageProps & {
  createdCnt: number;
  executedCnt: number;
};

const Dashboard: React.FC<Props> = ({ auth, createdCnt, executedCnt }) => {
  return (
    <AuthenticatedLayout user={auth.user} header={<h1>Dashboard</h1>}>
      <Head title="Dashboard" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">You're logged in!</div>
          </div>
        </div>
      </div>

      <section className="achievement">
        <h2>Achievement</h2>
        <p>
          Created test specification document sheets:
          <strong>{createdCnt}</strong>
        </p>
        <p>
          Executed test specification document sheets:
          <strong>{executedCnt}</strong>
        </p>
      </section>
    </AuthenticatedLayout>
  );
};

export default Dashboard;
