<template>
  <PageComponent>
     <template v-slot:header>
        <div class="flex items-center justify-between">
           <h1 class="text-3xl font-bold text-gray-900">
            Create a Product
           </h1>
        </div>

     </template>
       <form @submit="saveProduct">
          <div class="shadow sm:rounded-md sm:overflow-hidden">
             <div class="px-4 py-5 bg-white  space-y-6 sm:p-6">
                 <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Image
                    </label>
                    <div class="mt-1 flex items-center">
                        <img v-if="model.image_url" :src="model.image_url" :alt="model.name" class="w-64 h-48 object-cover"/>
                        <span v-else class="flex items-center justify-center h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="h-[80%] w-[80%] text-gray-300">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>

                        </span>
                        <button type="button"
                        class="relative overflow-hidden ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                           <input type="file" @change="onImageSelect" class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer" />
                        Change
                        </button>
                    </div>
                 </div>
                 <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" v-model="model.name" class="mt-1 appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" />
                 </div>
                 <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="text" name="price" id="price" v-model="model.price" class="mt-1 appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"/>
                 </div>
                 <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <input type="text" name="description" id="description" v-model="model.description" class="mt-1 appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"/>
                 </div>

                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button
                type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save changes
                </button>
                </div>
            </div>

        
       </form>
  </PageComponent>
</template>

<script setup>
import store from '../store';
import {ref} from 'vue';
import { useRoute,useRouter } from 'vue-router';
import PageComponent from '../components/PageComponent.vue';
const route=useRoute();
const router=useRouter();
let model=ref({
  name:'',
  price:'',
  image:'',
  image_url:'',
  description:'',

});
// if(route.params.id){
//     model.value=store.state.products.find((s)=>s.id===parseInt(route.params.id));
// }
function saveProduct(e)
{
   e.preventDefault();
   store.dispatch("saveProduct",model.value).then(({data})=>{
      router.push({
         name:'Products',
         // params:{id:data.data.id}
      })
   })
}
function onImageSelect(e)
{
   const file=e.target.files[0];
   const reader=new FileReader();
   reader.onload=()=>{
      model.value.image=reader.result;
      model.value.image_url=reader.result;
   }
   reader.readAsDataURL(file);
}
</script>

<style>

</style>