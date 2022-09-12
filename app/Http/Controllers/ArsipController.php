<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Document::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $json = json_encode($data);
                    $file = $data->file;
                    $btn = "<td>
                    <a class='btn btn-danger' onclick='deleteModal($json)' data-bs-toggle='modal' data-bs-target='#exampleModalCenter'>Hapus</a>
                    <a class='btn btn-secondary' href='$file' target='_href'>Unduh</a>
                    <a class='btn btn-primary' onclick='viewPage($json)'>Lihat</a>
                    </td>";
                    return $btn;
                })
                ->addColumn('created_at', function ($row){
                    return $row->created_at->format('d-M-Y');
                })
                ->rawColumns(['action','created_at'])

                ->make(true);
        }
        return view('admin.dokumen.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $table = new Document();
        $table->no_document = $request->no_document;
        $table->title = $request->title;
        $table->category = $request->category;
        if ($request->file('file')) {
            $file = $request->file;
            $file_name =  time() . "." . $file->getClientOriginalExtension();
            $path = public_path('assets/file/documents/');
            $file->move($path, $file_name);
            $file_data = 'assets/file/documents/' . $file_name;
            $table->file = $file_data;
        }
        $table->save();
        return response()->json(['data' => $table], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $table = Document::find($request->id);
        $table->no_document = $request->no_document;
        $table->title = $request->title;
        $table->category = $request->category;
        if ($request->file('file')) {
            $file = $request->file;
            $file_name =  time() . "." . $file->getClientOriginalExtension();
            $path = public_path('assets/file/documents/');
            $file->move($path, $file_name);
            $file_data = 'assets/file/documents/' . $file_name;
            $table->file = $file_data;
        }
        $table->save();
        return response()->json(['data' => $table], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $table = Document::find($request->id)->delete();
        return response()->json(['data' =>$table], 200);
    }
}
