<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('chance_of_playing_next_round')->nullable();
            $table->integer('chance_of_playing_this_round')->nullable();
            $table->integer('code')->nullable();
            $table->integer('cost_change_event')->default(0);
            $table->integer('cost_change_event_fall')->default(0);
            $table->integer('cost_change_start')->default(0);
            $table->integer('cost_change_start_fall')->default(0);
            $table->integer('dreamteam_count')->default(0);
            $table->integer('element_type')->default(1);
            $table->string('ep_next')->default("0.0");
            $table->string('ep_this')->default("0.0");
            $table->integer('event_points')->default(0);
            $table->string('first_name');
            $table->string('form')->default("0.0");
            $table->boolean('in_dreamteam')->default(false);
            $table->string('news')->default("");
            $table->string('news_added')->nullable();
            $table->integer('now_cost');
            $table->string('photo');
            $table->string('points_per_game')->default("0.0");
            $table->string('second_name');
            $table->string('selected_by_percent')->default("0.0");
            $table->boolean('special')->default(false);
            $table->integer('squad_number')->nullable();
            $table->string('status')->default("a");
            $table->integer('team');
            $table->integer('team_code');
            $table->integer('total_points')->default(0);
            $table->integer('transfers_in');
            $table->integer('transfers_in_event');
            $table->integer('transfers_out');
            $table->integer('transfers_out_event');
            $table->string('value_form')->default("0.0");
            $table->string('value_season')->default("0.0");
            $table->string('web_name');
            $table->integer('minutes')->default(0);
            $table->integer('goals_scored')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('clean_sheets')->default(0);
            $table->integer('goals_conceded')->default(0);
            $table->integer('own_goals')->default(0);
            $table->integer('penalties_saved')->default(0);
            $table->integer('penalties_missed')->default(0);
            $table->integer('yellow_cards')->default(0);
            $table->integer('red_cards')->default(0);
            $table->integer('saves')->default(0);
            $table->integer('bonus')->default(0);
            $table->integer('bps')->default(0);
            $table->string('influence')->default("0.0");
            $table->string('creativity')->default("0.0");
            $table->string('threat')->default("0.0");
            $table->string('ict_index')->default("0.0");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
