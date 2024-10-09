import React from 'react'
import { Helmet } from 'react-helmet';
import Layout from '../Layout';

const Index = ({ title }) => {
    return (
        <Layout>
            <Helmet>
                <title>{title}</title>
                <meta name="description" content="This is an example page description." />
                <meta name="keywords" content="example, inertia, react" />
            </Helmet>
            <h1>Dashboard</h1>
        </Layout>
    )
}

export default Index;
