<?php


namespace App\Services;

use App\Core\DB;
use App\Models\Comment;
use App\Models\User;
use App\Requests\CommentCreateRequest;
use App\Requests\UserCreateRequest;
use PDO;

class ArticleService
{
    protected PDO $connection;
    protected User $user;
    protected Comment $comment;

    public function __construct()
    {
        $dbInstance = DB::getInstance();
        $this->connection = $dbInstance->getConnection();
        $this->user = new User();
        $this->comment = new Comment();
    }

    /**
     * @param array $commentData
     * @return array|string
     */
    public function storeCommentData(array $commentData): array|string
    {
        $userValidate = (new UserCreateRequest($commentData))->validate();

        if (!$userValidate['status']) {
            return "Error validate: " . implode('', $userValidate['messages']);
        }

        $request = [
            'table' => 'users',
            'data' => $userValidate['fields']
        ];

        $userId = $this->user->findOrCreateEntity($request);

        $validate = (new CommentCreateRequest($commentData))->validate();

        if (!$validate['status']) {
            return "Error validate: " . implode('', $validate['messages']);
        }

        $commentValidate = $validate['fields'];

        $commentValidate['user_id'] = $userId;
        $commentValidate['created_at'] = $commentData['created_at'] = date('Y-m-d H:i:s');

        $request = [
            'table' => 'comments',
            'data' => $commentValidate
        ];

        $commentId = $this->comment->createEntity($request);

        return $commentData;
    }

    /**
     * @param string $sortByName
     * @param string $sortByDate
     * @return array
     */
    public function getCommentsWithUsersSort(string $sortByName = 'ASC', string $sortByDate = 'DESC'): array
    {
        $sql = "
        SELECT comments.id, comments.comment, comments.created_at, comments.user_id, 
               users.username, users.email 
        FROM comments 
        LEFT JOIN users ON users.id=comments.user_id 
        ORDER BY created_at {$sortByDate}, username {$sortByName};";

        return DbHelper::executeQuery($sql);
    }

    /**
     * @param $commentData
     * @return string
     */
    public function getCommentView($commentData): string
    {
        return "<div class='card' style='width: 36rem;'>
                    <div class='card-body'>
                        <h5 class='card-title'>
                            {$commentData['username']}
                        </h5>
                        <h6 class='card-subtitle mb-2 text-muted font-italic comment_italic'>
                            {$commentData['email']}
                        </h6>
                        <p class='card-text bg-comment m-1 p-1'>
                            {$commentData['comment']}
                        </p>
                        <p class='comment_italic small font-italic'>
                            {$commentData['created_at']}
                        </p>
                   </div>
               </div>";
    }

    /**
     * @param array $sortData
     * @return string
     */
    public function sortCommentsView(array $sortData): string
    {
        $sortByName = $sortData['sortByName'];
        $sortByDate = $sortData['sortByDate'];

        $commentsData = $this->getCommentsWithUsersSort($sortByName, $sortByDate);

        $output = '';
        foreach ($commentsData as $commentData) {
            $output .= $this->getCommentView($commentData);
        }

        return $output;
    }

    /**
     * @param int $count
     * @return string
     */
    public function getSampleArticle(int $count = 5): string
    {
        $row = [];

        $row[0] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lectus nulla at volutpat diam. Aenean et tortor at risus viverra adipiscing at in. Dictum fusce ut placerat orci nulla pellentesque. Tincidunt lobortis feugiat vivamus at augue eget. Nascetur ridiculus mus mauris vitae ultricies leo integer. Commodo viverra maecenas accumsan lacus. Lobortis mattis aliquam faucibus purus in. Consectetur adipiscing elit ut aliquam purus sit. Erat nam at lectus urna. Aenean euismod elementum nisi quis eleifend quam. Odio ut sem nulla pharetra diam sit amet nisl. Ac odio tempor orci dapibus ultrices. Sit amet aliquam id diam maecenas ultricies mi eget. Consectetur libero id faucibus nisl tincidunt. Molestie a iaculis at erat pellentesque adipiscing commodo. Aliquam sem fringilla ut morbi tincidunt. Consequat nisl vel pretium lectus quam id leo in vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames. Dignissim convallis aenean et tortor at.';

        $row[1] = 'Et malesuada fames ac turpis egestas sed tempus urna. Lectus arcu bibendum at varius vel pharetra vel turpis nunc. Egestas integer eget aliquet nibh praesent tristique magna sit. Mauris vitae ultricies leo integer malesuada nunc vel risus. Massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada. Ac tincidunt vitae semper quis. Et tortor at risus viverra adipiscing at in tellus integer. Dolor purus non enim praesent. Arcu vitae elementum curabitur vitae. Est lorem ipsum dolor sit amet consectetur. Mi quis hendrerit dolor magna eget est lorem ipsum dolor.';

        $row[2] = 'Odio tempor orci dapibus ultrices in iaculis nunc. Cursus vitae congue mauris rhoncus aenean vel elit. Mauris pharetra et ultrices neque ornare aenean. Dis parturient montes nascetur ridiculus mus mauris vitae ultricies. Vitae turpis massa sed elementum. Dignissim cras tincidunt lobortis feugiat vivamus at augue eget arcu. Sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium. Lorem ipsum dolor sit amet consectetur adipiscing elit. Quis auctor elit sed vulputate. Vivamus arcu felis bibendum ut tristique. Adipiscing diam donec adipiscing tristique risus nec feugiat in fermentum. Lacus sed viverra tellus in. Hendrerit dolor magna eget est lorem ipsum dolor sit. Libero volutpat sed cras ornare arcu dui. Viverra accumsan in nisl nisi scelerisque eu ultrices.';

        $row[3] = 'Pellentesque nec nam aliquam sem et tortor consequat. Elit sed vulputate mi sit. Ornare arcu dui vivamus arcu felis bibendum. Enim neque volutpat ac tincidunt vitae semper quis lectus. Posuere lorem ipsum dolor sit amet consectetur. Sollicitudin tempor id eu nisl nunc mi. Ut tortor pretium viverra suspendisse potenti nullam. Est placerat in egestas erat imperdiet sed euismod nisi. Faucibus interdum posuere lorem ipsum. Ornare aenean euismod elementum nisi quis eleifend. Pellentesque habitant morbi tristique senectus. Mi bibendum neque egestas congue quisque egestas diam. Orci sagittis eu volutpat odio facilisis mauris sit. Urna nec tincidunt praesent semper feugiat nibh sed pulvinar. Arcu dui vivamus arcu felis bibendum ut. Euismod nisi porta lorem mollis aliquam ut porttitor leo a. Auctor neque vitae tempus quam pellentesque nec. Placerat orci nulla pellentesque dignissim.';

        $row[4] = 'Consequat semper viverra nam libero justo laoreet. Amet tellus cras adipiscing enim eu turpis. Amet justo donec enim diam vulputate. Etiam tempor orci eu lobortis elementum nibh tellus molestie nunc. At urna condimentum mattis pellentesque id nibh tortor id aliquet. Ipsum faucibus vitae aliquet nec ullamcorper sit amet risus nullam. Commodo nulla facilisi nullam vehicula ipsum a arcu cursus vitae. Volutpat odio facilisis mauris sit amet massa. Tellus integer feugiat scelerisque varius morbi enim nunc faucibus. Odio eu feugiat pretium nibh ipsum consequat nisl vel pretium. Quis commodo odio aenean sed adipiscing diam donec adipiscing tristique. Sed elementum tempus egestas sed sed risus. Suspendisse ultrices gravida dictum fusce ut placerat orci nulla. Ut tristique et egestas quis ipsum suspendisse.';

        $content = '';

        foreach ($row as $key => $item) {
            if ($key < $count) {
                $content .= '<p>' . $item . '</p>';
            }
        }

        return $content;
    }
}