<?php

namespace App\Api\V1\Http\Controllers\Post;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Post\PostRequest;
use App\Api\V1\Http\Resources\Post\{AllPostResource, ShowPostResource};
use App\Api\V1\Repositories\Post\PostRepositoryInterface;
use Exception;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Illuminate\Http\JsonResponse;

/**
 * @group Bài viết
 */

class PostController extends Controller
{
    use Response, UseLog;

    public function __construct(
        PostRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * DS bài viết
     *
     * DS bài viết đã xuất bản và sắp xếp theo thứ tự nổi bật giảm dần
     *
     * Trạng thái bài viết (status) gồm:
     * - 1: Đã xuất bản
     * - 2: Bản nháp
     *
     * Nổi bật (is_featured) gồm:
     * - 1: Bài viết nổi bật
     * - 2: Bài viết không nổi bật
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @queryParam page integer
     * Trang hiện tại, page > 0. Example: 1
     *
     * @queryParam limit integer
     * Số lượng bài viết trong 1 trang, limit > 0. Example: 1
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *         {
     *               "id": 4,
     *               "title": "Hé lộ ios 17 sắp ra mắt",
     *               "slug": "he-lo-ios-17-sap-ra-mat",
     *               "image": "http://localhost/topzone/public/uploads/images/accnhi96141892532044.png",
     *               "is_featured": true,
     *               "excerpt": "Hé lộ ios 17 sắp ra mắt",
     *               "posted_at": "2023-04-19 10:12:57"
     *           }
     *      ]
     * }
     *
     * @param PostRequest $request
     *
     * @return JsonResponse
     */
    public function index(PostRequest $request): JsonResponse
    {
        try {
            $posts = $this->repository->getAllPublishedAndSortFeatured(
                ...$request->validated()
            );

            $posts = new AllPostResource($posts);
            return $this->jsonResponseSuccess($posts);
        } catch (Exception $e) {
            $this->logError('Get published post failed:', $e);
            return $this->jsonResponseError('Get published post failed', 500);
        }
    }

    /**
     * Chi tiết bài viết
     *
     * Lấy chi tiết bài viết.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @pathParam id integer required
     * id bài viết. Example: 1
     *
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *           "id": 4,
     *           "title": "Hé lộ ios 17 sắp ra mắt",
     *           "slug": "he-lo-ios-17-sap-ra-mat",
     *           "image": "http://localhost/topzone/public/uploads/images/1597766959764584432044.png",
     *           "is_featured": true,
     *           "excerpt": "Hé lộ ios 17 sắp ra mắt",
     *           "content": "<p>H&eacute; lộ ios 17 sắp ra mắt</p>",
     *           "posted_at": "2023-04-19 10:12:57"
     *       }
     * }
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $post = $this->repository->findByPublished($id);
            $post = new ShowPostResource($post);
            return $this->jsonResponseSuccess($post);
        } catch (Exception $e) {
            $this->logError('Get post detail failed:', $e);
            return $this->jsonResponseError('Get post detail failed', 500);
        }
    }

    /**
     * DS bài viết liên quan
     *
     * Lấy danh sách bài viết liên quan.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @pathParam id integer required
     * id bài viết. Example: 1
     *
     * @queryParam page integer
     * Trang hiện tại, page > 0. Example: 1
     *
     * @queryParam limit integer
     * Số lượng bài viết trong 1 trang, limit > 0. Example: 1
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *         {
     *               "id": 4,
     *               "title": "Hé lộ ios 17 sắp ra mắt",
     *               "slug": "he-lo-ios-17-sap-ra-mat",
     *               "image": "http://localhost/topzone/public/uploads/images/accnhi96141892532044.png",
     *               "is_featured": true,
     *               "excerpt": "Hé lộ ios 17 sắp ra mắt",
     *               "posted_at": "2023-04-19 10:12:57"
     *           }
     *      ]
     * }
     *
     * @param $id
     * @param PostRequest $request
     *
     * @return JsonResponse
     */
    public function related($id, PostRequest $request): JsonResponse
    {
        try {
            $posts = $this->repository->getRelated($id, ...$request->validated());
            $posts = new AllPostResource($posts);
            return $this->jsonResponseSuccess($posts);
        } catch (Exception $e) {
            $this->logError('Get related post failed:', $e);
            return $this->jsonResponseError('Get related post failed', 500);
        }
    }

    /**
     * Tìm kiếm bài viết
     * 
     * Tìm kiếm bài post bằng từ khoá (title,nội dung,ngày,nổi bật)
     * 
     * Trạng thái bài viết: 
     *  + Nổi bậc: 2 (mặc định)
     *  + Không nổi bậc: 1 
     * 
     * @headersParam X-TOKEN-ACCESS string 
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @bodyParam tiltle string nullable Tiêu đề. Example: ios 17 sắp ra mắt
     * @bodyParam content string nullable Nội dung. Example: Hé lộ ios 17 sắp ra mắt
     * @bodyParam posted_at string date_format:Y-m-d nullable Ngày đăng. Example: 2023-04-19
     * @bodyParam is_featured integer nullable Trạng thái nổi bậc. Example: 2
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *         {
     *               "id": 4,
     *               "title": "Hé lộ ios 17 sắp ra mắt",
     *               "slug": "he-lo-ios-17-sap-ra-mat",
     *               "content": "he-lo-ios-17-sap-ra-mat",
     *               "image": "http://localhost/topzone/public/uploads/images/accnhi96141892532044.png",
     *               "is_featured": 2,
     *               "excerpt": "Hé lộ ios 17 sắp ra mắt",
     *               "posted_at": "2023-04-19 10:12:57"
     *           }
     *      ]
     * }
    */

    public function filter(PostRequest $request):JsonResponse
    {
        try {
            $posts = $this->repository->filterPost($request);
            return $this->jsonResponseSuccess( new AllPostResource($posts));
        } catch (Exception $e) {
            $this->logError('Filter post failed:', $e);
            return $this->jsonResponseError('Filter post failed', 500);
        }

    }
}
