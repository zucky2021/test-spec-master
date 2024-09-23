import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { PageProps } from '@/types';

type Props = PageProps & {
    createdCnt: number;
    executedCnt: number;
}

export default function Dashboard({ auth, createdCnt, executedCnt }: Props) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">You're logged in!</div>
                    </div>
                </div>
            </div>

            <section className="achievement">
                <h3>Achievement</h3>
                <p>Created test spec doc sheets: <strong>{createdCnt}</strong></p>
                <p>Executed test spec doc sheets: <strong>{executedCnt}</strong></p>
            </section>
        </AuthenticatedLayout>
    );
}
