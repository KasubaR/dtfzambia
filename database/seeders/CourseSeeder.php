<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'title'          => 'Entrepreneurship Basics',
                'description'    => 'Learn how to start, structure, and manage a business from the ground up. Covers business models, market research, and launch strategy.',
                'duration'       => '10 Days',
                'mode'           => 'Hybrid',
                'price'          => 1750,
                'icon'           => 'rocket_launch',
                'is_popular'     => true,
                'is_recommended' => true,
                'sort_order'     => 1,
                'modules'        => [
                    'Introduction to Entrepreneurship',
                    'Identifying Business Opportunities',
                    'Business Model Canvas',
                    'Market Research & Validation',
                    'Financial Basics for Startups',
                    'Pitching Your Business Idea',
                ],
            ],
            [
                'title'       => 'Digital Marketing Fundamentals',
                'description' => 'Master social media strategy, SEO, email marketing, and paid ads to grow any business online in the modern digital landscape.',
                'duration'    => '10 Days',
                'mode'        => 'Hybrid',
                'price'       => 1750,
                'icon'        => 'campaign',
                'is_popular'  => true,
                'is_new'      => true,
                'sort_order'  => 2,
                'modules'     => [
                    'Social Media Strategy',
                    'Search Engine Optimisation (SEO)',
                    'Email Marketing Campaigns',
                    'Paid Advertising (Meta & Google)',
                    'Analytics & Reporting',
                ],
            ],
            [
                'title'       => 'Web Design & Development',
                'description' => 'Build professional websites from scratch using HTML, CSS, and beginner JavaScript. No prior experience required.',
                'duration'    => '10 Days',
                'mode'        => 'Hybrid',
                'price'       => 1750,
                'icon'        => 'code',
                'sort_order'  => 3,
                'modules'     => [
                    'HTML5 Structure & Semantics',
                    'CSS3 Styling & Layouts',
                    'Responsive Design (Mobile-First)',
                    'Introduction to JavaScript',
                    'Publishing Your Website',
                ],
            ],
            [
                'title'          => "AI for SME's",
                'description'    => 'Harness artificial intelligence tools like ChatGPT, Canva AI, and automation platforms to save time and scale your business.',
                'duration'       => '10 Days',
                'mode'           => 'Hybrid',
                'price'          => 1750,
                'icon'           => 'smart_toy',
                'is_recommended' => true,
                'is_new'         => true,
                'sort_order'     => 4,
                'modules'        => [
                    'Introduction to AI for Business',
                    'ChatGPT & Prompt Engineering',
                    'AI-Powered Design (Canva AI)',
                    'Workflow Automation Tools',
                    'AI Ethics & Best Practices',
                ],
            ],
            [
                'title'       => 'Graphic Design',
                'description' => 'Master visual communication and design principles — from typography and colour theory to branding, layouts, and digital graphics using industry-standard tools.',
                'duration'    => '10 Days',
                'mode'        => 'Hybrid',
                'price'       => 1750,
                'icon'        => 'palette',
                'sort_order'  => 5,
                'modules'     => [
                    'Design Principles & Colour Theory',
                    'Typography & Layout',
                    'Branding & Identity Design',
                    'Digital Graphics & Illustration',
                    'Print & Social Media Design',
                ],
            ],
        ];

        foreach ($courses as $data) {
            Course::updateOrCreate(
                ['title' => $data['title']],
                $data
            );
        }
    }
}
