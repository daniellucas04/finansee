<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-md">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium p-8">Your categories</h3>
                    <section class="mx-4">
                        <button class="flex items-center gap-2 text-white py-2 px-4 rounded-md gradient-primary" onclick="toggleModal('modal_new-category')">
                            <x-heroicon-s-plus-circle /> New category
                        </button>
                    </section>
                </div>
                    
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-8 py-1 text-start">Name</th>
                            <th class="px-8 py-1 text-start">Type</th>
                            <th class="px-8 py-1 text-start">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr class="border-b">
                                <td class="flex items-center gap-4 p-8 text-start">
                                    <span class="text-lg">
                                        {{ $category->name }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-start">
                                    <span class="{{ $category->type == 'Expense' ? 'bg-red-500' : 'bg-emerald-500' }} text-white rounded-full py-1 px-2 transition-colors duration-300 cursor-default">
                                        {{ $category->type }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-start">
                                    <x-dropdown align="left" width="40">
                                        <x-slot name="trigger">
                                            <button id class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                <x-heroicon-o-ellipsis-horizontal class="w-8 h-8 text-gray-500 hover:text-gray-600 transition-colors duration-300"/>
                                            </button>
                                        </x-slot>
        
                                        <x-slot name="content">
                                            <x-dropdown-link onclick="toggleModal('modal_edit-category#{{ $category->id }}')" class="cursor-pointer">
                                                {{ __('Edit') }}
                                            </x-dropdown-link>
                                        
                                            <x-dropdown-link onclick="confirmDelete({{ $category->id }})" class="text-red-500 hover:text-red-400 transition-colors duration-300 cursor-pointer">
                                                {{ __('Delete') }}

                                                <form id="form-delete-{{ $category->id }}"  action="{{ route('destroy.category', $category->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </x-dropdown-link>
                                        </x-slot>
                                    </x-dropdown>

                                    {{-- Edit Category Modal --}}
                                    <form id="modal_edit-category#{{ $category->id }}" action="{{ route('update.category', $category->id) }}" class="hidden fixed z-50 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-md shadow-lg border w-[90%] max-w-lg" method="post">
                                        @csrf
                                        @method('put')
                                        <header class="bg-white border rounded-md rounded-b-none py-2 px-6">
                                            <h3 class="text-xl">Edit your category</h3>
                                        </header>

                                        <main class="bg-white border-l border-r px-4 py-8">
                                            <div class="flex gap-4 my-2">
                                                <div class="flex flex-col flex-auto">
                                                    <label for="name">Name</label>
                                                    <input type="text" name="name" value="{{ $category->name }}" class="rounded-full py-1">
                                                </div>

                                                <div class="flex flex-col flex-auto">
                                                    <label for="type">Type</label>
                                                    <input list="types" id="category_types" name="type" value="{{ $category->type }}" class="rounded-full py-1">

                                                    <datalist id="types">
                                                        <option value="Income"></option>
                                                        <option value="Expense"></option>
                                                    </datalist>
                                                </div>

                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            </div>
                                        </main>
                                        
                                        <footer class="flex gap-4 justify-end py-2 px-6 bg-gray-50 border rounded-b-md">
                                            <button class="bg-red-500 text-white hover:bg-red-600 hover:text-zinc-100 transition-colors duration-300 py-1 px-6 rounded-full" type="button" onclick="closeModal('modal_edit-category#{{ $category->id }}')">Cancel</button>
                                            <button class="bg-blue-500 text-white hover:bg-blue-600 hover:text-zinc-100 transition-colors duration-300 py-1 px-6 rounded-full">Save</button>
                                        </footer>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <div class="m-4 text-center gradient-primary p-4 rounded-md text-white">Categories not found</div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Overlay --}}
    <div id="modal_overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40"></div>

    {{-- New Category Modal --}}
    <form id="modal_new-category" action="{{ route('store.category') }}" class="hidden fixed z-50 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-md shadow-lg border w-[90%] max-w-lg" method="post">
        @csrf
        @method('post')
        <header class="bg-white border rounded-md rounded-b-none py-2 px-6">
            <h3 class="text-xl">New category</h3>
        </header>

        <main class="bg-white border-l border-r px-4 py-8">
            <div class="flex gap-4 my-2">
                <div class="flex flex-col flex-auto">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="rounded-full py-1">
                </div>

                <div class="flex flex-col flex-auto">
                    <label for="type">Type</label>
                    <input list="types" id="category_types" name="type" class="rounded-full py-1">

                    <datalist id="types">
                        <option value="Income"></option>
                        <option value="Expense"></option>
                    </datalist>
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            </div>
        </main>

        <footer class="flex gap-4 justify-end py-2 px-6 bg-gray-50 border rounded-b-md">
            <button class="bg-red-500 text-white hover:bg-red-600 hover:text-zinc-100 transition-colors duration-300 py-1 px-6 rounded-full" type="button" onclick="closeModal('modal_new-category')">Cancel</button>
            <button class="bg-blue-500 text-white hover:bg-blue-600 hover:text-zinc-100 transition-colors duration-300 py-1 px-6 rounded-full">Create</button>
        </footer>
    </form>
</x-app-layout>

{{-- Modal --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const overlay = document.getElementById('modal_overlay');

    function toggleModal(id) {
        const modal = document.getElementById(id);
        overlay.classList.remove('hidden');
        
        modal.classList.remove('hidden', 'modal-leave');
        modal.classList.add('modal-enter');
    }
    
    function closeModal(id) {
        const modal = document.getElementById(id);

        modal.classList.remove('modal-enter');
        modal.classList.add('modal-leave');

        // Espera a animação terminar antes de esconder
        setTimeout(() => {
            modal.classList.add('hidden');
            overlay.classList.add('hidden');
        }, 300); // Tempo igual ao da animação 'modal-out'
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Warning!',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + id).submit();
            }
        })
    }
</script>