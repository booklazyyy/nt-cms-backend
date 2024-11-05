<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;


class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'user_id' => 2,
            'title' => 'test data',
            'data_json' => '{
                "pages": [
                    {
                        "id": "8XyEee03XvFVtrLg",
                        "type": "main",
                        "frames": [
                            {
                                "id": "8LIe552R5lZcErpn",
                                "component": {
                                    "head": {
                                        "type": "head"
                                    },
                                    "type": "wrapper",
                                    "docEl": {
                                        "tagName": "html"
                                    },
                                    "stylable": [
                                        "background",
                                        "background-color",
                                        "background-image",
                                        "background-repeat",
                                        "background-attachment",
                                        "background-position",
                                        "background-size"
                                    ],
                                    "components": [
                                        {
                                            "type": "link",
                                            "editable": false,
                                            "droppable": true,
                                            "attributes": {
                                                "id": "il82"
                                            }
                                        },
                                        {
                                            "type": "text",
                                            "classes": [
                                                "quote"
                                            ],
                                            "tagName": "blockquote",
                                            "components": [
                                                {
                                                    "type": "textnode",
                                                    "content": "\n        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit\n      "
                                                }
                                            ]
                                        }
                                    ]
                                }
                            }
                        ]
                    }
                ],
                "assets": [],
                "styles": [
                    {
                        "style": {
                            "display": "inline-block",
                            "padding": "5px",
                            "min-width": "50px",
                            "min-height": "50px"
                        },
                        "selectors": [
                            "#il82"
                        ]
                    }
                ],
                "symbols": []
            }',
            'content' => '<body><a id="il82"></a><blockquote class="quote">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit</blockquote></body>',
            'custom_css' => '* { box-sizing: border-box; } body {margin: 0;}#il82{display:inline-block;padding:5px;min-width:50px;min-height:50px;}',
            'guid' => '/test-data'
        ]);
    }
}
