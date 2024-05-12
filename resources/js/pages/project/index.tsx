import { Head, usePage } from '@inertiajs/react';
import { PageProps } from '@/types';
import { Card, CardContent } from '@/components/ui/card';
import SectionTitle from '@/components/section-title';
import { AppLayout } from '@/layouts/app-layout';
import Container from '@/components/container';

export default function Project({ projects }: any) {
    console.log({ projects });
    const { auth } = usePage<PageProps>().props;
    return (
        <>
            <Head title='projects' />
            <Container>
                <Card>
                    {projects.map((project: any) => (
                        <SectionTitle key={project.id} title={project.name} description={project.description} />
                    ))}
                </Card>
            </Container>
        </>
    );
}

Project.layout = (page: any) => <AppLayout children={page} />;
