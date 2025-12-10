import React from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import Hero from "./Welcome/Partials/Hero";
import AboutSection from "./Welcome/Partials/AboutSection";
import TopCategory from "./Welcome/Partials/TopCategory";
import FeaturedProducts from "./Welcome/Partials/FeaturedProducts";
import Features from "./Welcome/Partials/Features";
import BannerBottom from "./Welcome/Partials/BannerBottom";

export default function Welcome({ auth, featuredProducts, categories }) {
    const handleRestrictedAccess = (e, url) => {
        e.preventDefault();
        if (auth.user) {
            router.visit(url);
        } else {
            router.visit(route("login"));
        }
    };

    return (
        <MainLayout title="FreshMart - Organic Food Store">
            <Hero handleAccess={handleRestrictedAccess} />

            <AboutSection />

            <TopCategory
                categories={categories}
                handleAccess={handleRestrictedAccess}
            />

            <FeaturedProducts
                products={featuredProducts}
                handleAccess={handleRestrictedAccess}
            />

            <Features />

            <BannerBottom />
        </MainLayout>
    );
}
