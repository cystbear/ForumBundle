<?php

namespace Bundle\ForumBundle\Updater;

class TopicUpdaterTest extends \PHPUnit_Framework_TestCase
{
    public function testUpdate()
    {
        $post1 = $this->createPost();
        $post1->expects($this->once())
            ->method('setNumber')
            ->with(1);
        $post2 = $this->createPost();
        $post2->expects($this->once())
            ->method('setNumber')
            ->with(2);
        $post3 = $this->createPost();
        $post3->expects($this->once())
            ->method('setNumber')
            ->with(3);
        $posts = array($post1, $post2, $post3);

        $category = $this->getMockBuilder('Bundle\ForumBundle\Model\Category')
            ->disableOriginalConstructor()
            ->getMock();

        $topic = $this->getMockBuilder('Bundle\ForumBundle\Model\Topic')
            ->disableOriginalConstructor()
            ->getMock();
        $topic->expects($this->once())
            ->method('setNumPosts')
            ->with(3);
        $topic->expects($this->once())
            ->method('setFirstPost')
            ->with($post1);
        $topic->expects($this->once())
            ->method('setLastPost')
            ->with($post3);

        $postRepository = $this->getMockBuilder('Bundle\ForumBundle\Model\PostRepositoryInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $postRepository->expects($this->once())
            ->method('findAllByTopic')
            ->with($topic)
            ->will($this->returnValue($posts));

        $updater = new TopicUpdater($postRepository);
        $updater->update($topic);
    }

    public function createPost()
    {
        return $this->getMockBuilder('Bundle\ForumBundle\Model\Post')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
