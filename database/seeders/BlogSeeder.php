<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  // Ensure there are at least 5 tags and 3 categories
        //  if (Tag::count() < 5) {
        //     Tag::factory()->count(10)->create(); // if you don't have one, create a factory for Tag
        // }

        // if (Category::count() < 3) {
        //     Category::factory()->count(5)->create(); // if you don't have one, create a factory for Category
        // }

        $tags = Tag::pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();


        $blogs = [
            [
                "user_id" => 1,
                "title" => "Tricycle Driver Killed, Passenger Injured in Victorias Collision",
                "slug" => "tricycle-driver-killed-passenger-injured-victorias-collision",
                "content" => "On August 20, 2023, a tragic accident occurred in Barangay 13, Victorias City, when a tricycle was rear-ended by a Ceres bus along the national highway. The tricycle, driven by 25-year-old Elf Sanipa from Barangay 10, malfunctioned and swerved into the opposite lane, leading to the collision.\n\nThe impact resulted in the immediate death of Sanipa, while his passenger, 29-year-old Jenalyn Navarro from Barangay Vista Alegre, Bacolod City, sustained injuries. Navarro was promptly transported to Corazon Locsin Montelibano Memorial Regional Hospital in Bacolod City for medical treatment.\n\nAuthorities have impounded both vehicles involved for proper investigation. The bus driver, 49-year-old Lemuel Fajardo from Barangay Bug-ang, Toboso town, was temporarily detained at the Victorias Police Station pending further inquiries.",
                "featured_img" => "https://via.placeholder.com/640x480.png?text=Accident",
                "status" => "published",
                "is_featured" => false,
                "is_visible" => true,
                "metadata" => [
                    "seo_title" => "Tricycle Driver Killed, Passenger Injured in Victorias Collision",
                    "seo_description" => "A fatal collision in Victorias City resulted in the death of a tricycle driver and injuries to his passenger after being rear-ended by a Ceres bus.",
                    "seo_keywords" => "Victorias City, Negros Occidental, tricycle accident, Ceres bus, road collision"
                ]
            ],
            [
                "user_id" => 1,
                "title" => "One Dead, Five Injured in Victorias Vehicle Collision",
                "slug" => "one-dead-five-injured-victorias-vehicle-collision",
                "content" => "A severe vehicular accident transpired on Osmeña Avenue in Victorias City, leading to the death of a 19-year-old resident from Cadiz City and injuries to five others. The collision involved a refrigerated van and a dump truck.\n\nThe incident occurred when the refrigerated van, traveling at high speed, lost control and collided head-on with the dump truck. The force of the impact caused significant damage to both vehicles and resulted in multiple injuries among the occupants.\n\nEmergency responders arrived promptly, providing immediate medical assistance and transporting the injured to nearby hospitals. Authorities are conducting a thorough investigation to determine the exact cause of the accident and to implement measures to prevent similar incidents in the future.",
                "featured_img" => "https://via.placeholder.com/640x480.png?text=Accident",
                "status" => "published",
                "is_featured" => false,
                "is_visible" => true,
                "metadata" => [
                    "seo_title" => "One Dead, Five Injured in Victorias Vehicle Collision",
                    "seo_description" => "A head-on collision between a refrigerated van and a dump truck in Victorias City resulted in one fatality and multiple injuries.",
                    "seo_keywords" => "Victorias City, Negros Occidental, vehicle collision, road accident, Osmeña Avenue"
                ]
            ],
            [
                "user_id" => 1,
                "title" => "Elderly Man and Nephew Killed in Victorias Road Accident",
                "slug" => "elderly-man-nephew-killed-victorias-road-accident",
                "content" => "On September 19, 2024, a heartbreaking accident claimed the lives of an elderly man and his young nephew in Victorias City. The duo was traveling along a local road when their vehicle was involved in a fatal collision.\n\nPreliminary reports indicate that the vehicle lost control due to mechanical failure, veering off the road and crashing into a concrete barrier. The impact was so severe that both occupants were pronounced dead at the scene.\n\nLocal authorities have initiated an investigation to ascertain the exact cause of the accident. The community mourns the loss of the two individuals, emphasizing the need for regular vehicle maintenance and road safety awareness.",
                "featured_img" => "https://via.placeholder.com/640x480.png?text=Accident",
                "status" => "published",
                "is_featured" => false,
                "is_visible" => true,
                "metadata" => [
                    "seo_title" => "Elderly Man and Nephew Killed in Victorias Road Accident",
                    "seo_description" => "A tragic accident in Victorias City resulted in the deaths of an elderly man and his nephew after their vehicle crashed into a barrier.",
                    "seo_keywords" => "Victorias City, Negros Occidental, road accident, vehicle crash, fatalities"
                ]
            ]
        ];

        foreach ($blogs as $data) {
            $blog = Blog::create($data);

             // Attach 5 random tags
            $blog->tags()->attach(array_rand(array_flip($tags), 5));

            // Attach 3 random categories
            $blog->categories()->attach(array_rand(array_flip($categories), 3));


        }
    }
}
