@extends('layout.app')

@section('content')
<div class="container mx-auto p-8 max-w-7xl">
    <div class="flex items-center justify-between">
        <h1 class="text-5xl font-extrabold mb-10 text-gray-800">Drafts</h1>
        <a href="{{ route('article.index') }}" class="bg-red-600 text-white px-6 py-2 rounded-lg shadow-lg hover:bg-red-700 transition duration-300">
                Back to Dashboard
        </a>
    </div>

    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Author</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Submitted At</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($drafts as $draft)
                    <tr class="hover:bg-gray-100 transition duration-200 ease-in-out">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <a href="{{ route('drafts.show', $draft->id) }}" class="text-blue-600 hover:text-blue-800">
                                {{ $draft->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $draft->author }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $draft->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $draft->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($draft->status) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('drafts.approve', $draft->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-800 font-semibold">Approve</button>
                            </form>

                            <form action="{{ route('drafts.pending', $draft->id) }}" method="POST" class="inline-block ml-3">
                                @csrf
                                <button type="submit" class="text-yellow-600 hover:text-yellow-800 font-semibold">Pending</button>
                            </form>

                            <form action="{{ route('drafts.notapproved', $draft->id) }}" method="POST" class="inline-block ml-3">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Not Approved</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
