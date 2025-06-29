@extends('layout.master')

@section('content')
    <div class="content">
        <div class="card p-4 mt-3">
            <table class="table">
                <tbody>
                    @foreach ($macAddresses as $mac)
                        <tr>
                            <td>{{ $mac->mac }}</td>
                            <td>
                                <form action="{{ route('mac.destroy', $mac->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-dark">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
