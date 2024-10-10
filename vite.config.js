

import { defineConfig } from 'vite';                                                 
import laravel from 'laravel-vite-plugin';                                           
import tailwindcss from 'tailwindcss';                                               
import autoprefixer from 'autoprefixer';                                             
                                                                                     
export default defineConfig({                                                        
    plugins: [                                                                       
        laravel({                                                                    
            input: ['resources/css/tailwind.css', 'resources/js/inertia.jsx'],                
            refresh: true,                                                           
        }),                                                                          
    ],                                                                               
    css: {                                                                           
        postcss: {                                                                   
            plugins: [                                                               
                tailwindcss,                                                         
                autoprefixer,                                                        
            ],                                                                       
        },                                                                           
    },                                                                               
});                                                                                  