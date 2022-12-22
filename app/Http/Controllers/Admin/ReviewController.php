<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Traits\ActionsTrait;
use App\Models\Review;
use App\Repositories\ReviewRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class ReviewController extends Controller
{
    use ActionsTrait;
    private $reviewRepository;
    public $resource = 'review';

    public function __construct(ReviewRepository $reviewRepository)
    {
        appendGeneralPermissions($this);
        $this->reviewRepository = $reviewRepository;
        view()->share('item', $this->resource);
        view()->share('class', Review::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.crud.index');
    }

    public function show( Review $review)
    {
        return view('admin.review.show', compact('review'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Review $review
     * @return RedirectResponse
     */
    public function destroy(Request $request, Review $review): RedirectResponse
    {
        $this->reviewRepository->delete($review);
        $request->session()->flash('success', 'review deleted successfully');
        return redirect()->route('admin.reviews.index');
    }

    public function getReviews(Request $request, Review $review): JsonResponse
    {
        $reviews =   $this->reviewRepository->getReviewsDataTable($request);

        $data = [];

        foreach ($reviews as $review) {
            $imageUrl = $review->user->avatar ? storageImage($review->user->avatar) : asset('assets/media/svg/icons/General/User.svg');
            $data[] = [
                'id' => $review->id,
                'image' => $this->getImageUrl($imageUrl, $review->user->id),
                'name' => $review->user->name,
                'review' => $review->review,
                'review_content' => $review->review_content,
                'created_at' => Date::parse($review->created_at)->format('Y-m-d'),
                'actions' => $this->getItemActions($review, $this->resource)
            ];
        }

        return response()->json(
            [
                "meta"=> [
                    "page"=> $reviews->currentPage(),
                    "pages"=> $reviews->lastPage(),
                    "perpage"=> $reviews->perPage(),
                    "total"=> $reviews->total() ,
                    "sort"=> $request->get('sort')['sort'] ?? 0,
                    "field"=> $request->get('sort')['field'] ?? ''
                ],
                "data"=> $data,
            ]
        );
    }
}
