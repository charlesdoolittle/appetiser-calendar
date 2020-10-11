<?php

namespace Tests\Unit;

use App\Event;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;


class EventTest extends TestCase
{

    public function test_can_create_event(){
        $data = [
            'event_name' => 'My test event.',
            'start_date' => '2020-10-10',
            'end_date' => '2020-10-20',
            'event_days' => [1,2,3,4]
        ];

        $this->post(route('event.save'), $data)
             ->assertStatus(201)
             ->assertJson(['event' => $data]);
    }

    public function test_can_update_event_with_same_date_range(){
        $sd = '2020-10-10';
        $ed = '2020-10-20';

        $data = [
            'event_name' => 'My test event.',
            'start_date' => $sd,
            'end_date' => $ed,
            'event_days' => [0,2,4,6]
        ];

        $this->post(route('event.save'), $data)
             ->assertStatus(201)
             ->assertJson(['event' => array_merge($data, array('event_key' => md5($sd.$ed)))]);
    }

    public function test_can_get_events(){
        $this->get(route('events'))
             ->assertStatus(200)
             ->assertJsonStructure(['events' => []]);
    }
}
