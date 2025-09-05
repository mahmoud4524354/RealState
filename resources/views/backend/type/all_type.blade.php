@extends('admin.home.master')
@section('content')

    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">🏠 All Property Types</h4>
            <a href="{{ route('add.type') }}" class="btn btn-primary">
                <i class="feather icon-plus"></i> Add Property Type
            </a>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Property Type</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table table-striped table-hover align-middle text-center">
                                <thead class="table-dark">
                                <tr>
                                    <th style="width: 70px;">#</th>
                                    <th style="width: 30%;">Type Name</th>
                                    <th style="width: 30%;">Type Icon</th>
                                    <th style="width: 200px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($types) > 0)
                                    @foreach($types as $key => $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-capitalize">{{ $item->type_name }}</td>
                                            <td>
                                                <i class="{{ $item->type_icon }} me-2"></i>
                                                {{ $item->type_icon }}
                                            </td>
                                            <td>
                                                <a href="{{ route('edit.type',$item->id) }}"
                                                   class="btn btn-sm btn-warning me-2">
                                                    <i class="feather icon-edit"></i> Edit
                                                </a>
                                                <a href="{{ route('delete.type',$item->id) }}"
                                                   class="btn btn-sm btn-danger" id="delete">
                                                    <i class="feather icon-trash-2"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">
                                            <i class="feather icon-info"></i> No Records Found
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
