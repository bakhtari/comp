<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreateCompanyRequest;
use App\Http\Requests\Api\V1\IndexCompanyRequest;
use App\Http\Resources\Api\V1\IndexCompanyCollection;
use App\Http\Resources\V1\ArticleCollection;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Resources\Api\V1\IndexCompanyResource;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function create(CreateCompanyRequest $request)
    {
        Company::create(["name" => $request->name, "uid" => $request->uid]);
        return response()->json(["success" => true, 'message' => "company has been created."]);
    }

    public function index(IndexCompanyRequest $request)
    {
        $total = Company::orderBy("name", "asc")->count();
        if ($total == 0) return Response::json(['data' => false], 204);
        if (!$request->perPage) $perPage = 3;
        elseif ($request->perPage > 5) $perPage = 5;

        $totalPages = ceil($total / $perPage);
        if (!$request->page) $page = 1;
        elseif ($request->page > $totalPages) $page = $totalPages;
        else $page = $request->page;

        $start = ($page - 1) * $perPage;

        $list = Company::orderBy("name", "asc")->skip($start)->take($perPage)->get();

        if (($page + 1) > $totalPages) $nextPage = null;
        else $nextPage = $page + 1;

        $meta = collect();
        $meta->add(['currentPage' => (int)$page, 'perPage' => $perPage, 'nextPageNo' => $nextPage, 'baseUrl' => url("/api/v1/company/index"), 'totalPages' => $totalPages]);

        return new IndexCompanyCollection(['data' => $list, 'meta' => $meta]);
    }
}
