<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase; // Reset the database for each test

    public function test_projects_by_status_method(): void
    {
        // Create a company
        $company = Company::factory()->create();

        // Create teams associated with the company
        $team1 = Team::factory()->create(['company_id' => $company->id]);
        $team2 = Team::factory()->create(['company_id' => $company->id]);

        // Create projects with different statuses, associated with the teams
        $activeProject1 = Project::factory()->create(['team_id' => $team1->id, 'status' => 'active']);
        $activeProject2 = Project::factory()->create(['team_id' => $team2->id, 'status' => 'active']);
        $completedProject = Project::factory()->create(['team_id' => $team1->id, 'status' => 'completed']);
        $onHoldProject = Project::factory()->create(['team_id' => $team2->id, 'status' => 'on-hold']);

        // Test the projectsByStatus method for 'active' projects
        $activeProjects = $company->projectsByStatus('active')->get();
        $this->assertCount(2, $activeProjects);
        $this->assertTrue($activeProjects->contains('id', $activeProject1->id));
        $this->assertTrue($activeProjects->contains('id', $activeProject2->id));
        $this->assertFalse($activeProjects->contains('id', $completedProject->id));
        $this->assertFalse($activeProjects->contains('id', $onHoldProject->id));

        // Test the projectsByStatus method for 'completed' projects
        $completedProjects = $company->projectsByStatus('completed')->get();
        $this->assertCount(1, $completedProjects);
        $this->assertTrue($completedProjects->contains('id', $completedProject->id));
        $this->assertFalse($completedProjects->contains('id', $activeProject1->id));
        $this->assertFalse($completedProjects->contains('id', $activeProject2->id));
        $this->assertFalse($completedProjects->contains('id', $onHoldProject->id));

        // Test the projectsByStatus method for 'on-hold' projects.
        $onHoldProjects = $company->projectsByStatus('on-hold')->get();
        $this->assertCount(1, $onHoldProjects);
        $this->assertTrue($onHoldProjects->contains('id', $onHoldProject->id));
        $this->assertFalse($onHoldProjects->contains('id', $activeProject1->id));
        $this->assertFalse($onHoldProjects->contains('id', $activeProject2->id));
        $this->assertFalse($onHoldProjects->contains('id', $completedProject->id));

        //Test with a status that doesn't exist
        $noProjects = $company->projectsByStatus('does-not-exist')->get();
        $this->assertCount(0, $noProjects);

        // Test with a different company (should return no projects)
        $anotherCompany = Company::factory()->create();
        $anotherCompanyProjects = $anotherCompany->projectsByStatus('active')->get();
        $this->assertCount(0, $anotherCompanyProjects);
    }

    public function test_projects_relationship_through_teams(): void
    {
        // Create a company
        $company = Company::factory()->create();

        // Create teams for the company
        $team1 = Team::factory()->create(['company_id' => $company->id]);
        $team2 = Team::factory()->create(['company_id' => $company->id]);

        // Create projects for the teams
        $project1 = Project::factory()->create(['team_id' => $team1->id]);
        $project2 = Project::factory()->create(['team_id' => $team1->id]);
        $project3 = Project::factory()->create(['team_id' => $team2->id]);

        // Get all projects associated with the company through its teams
        $allProjects = $company->teams()->with('projects')->get()->pluck('projects')->flatten();

        // Assert that the correct number of projects are retrieved
        $this->assertCount(3, $allProjects);

        // Assert that the retrieved projects are the ones we created
        $this->assertTrue($allProjects->contains('id', $project1->id));
        $this->assertTrue($allProjects->contains('id', $project2->id));
        $this->assertTrue($allProjects->contains('id', $project3->id));

        // Test with a different company (should return no projects)
        $anotherCompany = Company::factory()->create();
        $anotherCompanyProjects = $anotherCompany->teams()->with('projects')->get()->pluck('projects')->flatten();
        $this->assertCount(0, $anotherCompanyProjects);
    }
} 