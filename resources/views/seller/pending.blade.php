@extends('layouts.seller')

@section('title', 'Store Pending Verification')

@section('content')
<div class="max-w-2xl mx-auto text-center py-12">
    <div class="bg-warning-100 p-6 rounded-full inline-block mb-6">
        <svg class="w-16 h-16 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    
    <h1 class="text-3xl font-bold mb-4" style="color: #252B42;">Store Pending Verification</h1>
    <p class="text-gray-600 mb-8">
        Your store <strong>{{ auth()->user()->store->name }}</strong> is currently being reviewed by our admin team.
        <br>You will be notified once your store is verified.
    </p>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-left">
        <h3 class="font-bold text-gray-900 mb-3">What happens next?</h3>
        <ul class="space-y-2 text-sm text-gray-600">
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-primary-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Our admin team will review your store information
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-primary-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Verification usually takes 1-2 business days
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-primary-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Once verified, you can start adding products and accepting orders
            </li>
        </ul>
    </div>

    <div class="mt-8">
        <a href="{{ route('home') }}" class="btn-outline">
            Back to Homepage
        </a>
    </div>
</div>
@endsection
