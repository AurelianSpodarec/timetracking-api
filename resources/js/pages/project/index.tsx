import { Head, usePage } from '@inertiajs/react';
import { PageProps } from '@/types';
import { Card, CardContent } from '@/components/ui/card';
import SectionTitle from '@/components/section-title';
import { AppLayout } from '@/layouts/app-layout';
import Container from '@/components/container';

export default function Project({ projects }: any) {
    const { auth, session } = usePage<PageProps>().props;
    // @todo this is getting rendered twice, figure out why it is doing that and fix it please, I might be wrong about this but needs checking from an FE engineering side. Check how the guy put that together
    console.log({ projects, auth });
    return (
        <>
            <Head title='projects' />
            <Container>
                <Card>
                    {projects.map((project: any) => (
                        <SectionTitle key={project.id} title={project.name} description={`£ ${project.hourly_rate}`} />
                    ))}
                </Card>
            </Container>
        </>
    );
}

Project.layout = (page: any) => <AppLayout children={page} />;
