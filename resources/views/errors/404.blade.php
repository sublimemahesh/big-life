@extends('errors::custom-layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __($exception->getMessage()) ?: __('Not Found!'))
