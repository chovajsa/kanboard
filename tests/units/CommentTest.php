<?php

require_once __DIR__.'/Base.php';

use Model\Task;
use Model\Project;
use Model\Comment;

class CommentTest extends Base
{
    public function testCreate()
    {
        $c = new Comment($this->db, $this->event);
        $t = new Task($this->db, $this->event);
        $p = new Project($this->db, $this->event);

        $this->assertEquals(1, $p->create(array('name' => 'test1')));
        $this->assertEquals(1, $t->create(array('title' => 'test', 'project_id' => 1, 'column_id' => 3, 'owner_id' => 1)));
        $this->assertTrue($c->create(array('task_id' => 1, 'comment' => 'bla bla', 'user_id' => 1)));

        $comment = $c->getById(1);

        $this->assertNotEmpty($comment);
        $this->assertEquals('bla bla', $comment['comment']);
        $this->assertEquals(1, $comment['task_id']);
        $this->assertEquals(1, $comment['user_id']);
        $this->assertEquals('admin', $comment['username']);
        $this->assertNotEmpty($comment['date']);
    }

    public function testGetAll()
    {
        $c = new Comment($this->db, $this->event);
        $t = new Task($this->db, $this->event);
        $p = new Project($this->db, $this->event);

        $this->assertEquals(1, $p->create(array('name' => 'test1')));
        $this->assertEquals(1, $t->create(array('title' => 'test', 'project_id' => 1, 'column_id' => 3, 'owner_id' => 1)));
        $this->assertTrue($c->create(array('task_id' => 1, 'comment' => 'c1', 'user_id' => 1)));
        $this->assertTrue($c->create(array('task_id' => 1, 'comment' => 'c2', 'user_id' => 1)));
        $this->assertTrue($c->create(array('task_id' => 1, 'comment' => 'c3', 'user_id' => 1)));

        $comments = $c->getAll(1);

        $this->assertNotEmpty($comments);
        $this->assertEquals(3, count($comments));
        $this->assertEquals(1, $comments[0]['id']);
        $this->assertEquals(2, $comments[1]['id']);
        $this->assertEquals(3, $comments[2]['id']);
    }

    public function testUpdate()
    {
        $c = new Comment($this->db, $this->event);
        $t = new Task($this->db, $this->event);
        $p = new Project($this->db, $this->event);

        $this->assertEquals(1, $p->create(array('name' => 'test1')));
        $this->assertEquals(1, $t->create(array('title' => 'test', 'project_id' => 1, 'column_id' => 3, 'owner_id' => 1)));
        $this->assertTrue($c->create(array('task_id' => 1, 'comment' => 'c1', 'user_id' => 1)));
        $this->assertTrue($c->update(array('id' => 1, 'comment' => 'bla')));

        $comment = $c->getById(1);
        $this->assertNotEmpty($comment);
        $this->assertEquals('bla', $comment['comment']);
    }

    public function testValidateCreation()
    {
        $c = new Comment($this->db, $this->event);

        $result = $c->validateCreation(array('user_id' => 1, 'task_id' => 1, 'comment' => 'bla'));
        $this->assertTrue($result[0]);

        $result = $c->validateCreation(array('user_id' => 1, 'task_id' => 1, 'comment' => ''));
        $this->assertFalse($result[0]);

        $result = $c->validateCreation(array('user_id' => 1, 'task_id' => 'a', 'comment' => 'bla'));
        $this->assertFalse($result[0]);

        $result = $c->validateCreation(array('user_id' => 'b', 'task_id' => 1, 'comment' => 'bla'));
        $this->assertFalse($result[0]);

        $result = $c->validateCreation(array('user_id' => 1, 'comment' => 'bla'));
        $this->assertFalse($result[0]);

        $result = $c->validateCreation(array('task_id' => 1, 'comment' => 'bla'));
        $this->assertFalse($result[0]);

        $result = $c->validateCreation(array('comment' => 'bla'));
        $this->assertFalse($result[0]);

        $result = $c->validateCreation(array());
        $this->assertFalse($result[0]);
    }

    public function testValidateModification()
    {
        $c = new Comment($this->db, $this->event);

        $result = $c->validateModification(array('id' => 1, 'comment' => 'bla'));
        $this->assertTrue($result[0]);

        $result = $c->validateModification(array('id' => 1, 'comment' => ''));
        $this->assertFalse($result[0]);

        $result = $c->validateModification(array('comment' => 'bla'));
        $this->assertFalse($result[0]);

        $result = $c->validateModification(array('id' => 'b', 'comment' => 'bla'));
        $this->assertFalse($result[0]);

        $result = $c->validateModification(array());
        $this->assertFalse($result[0]);
    }
}
