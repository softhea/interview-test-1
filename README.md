
# Code test assignment

## Description

In this test assignment we have prepared a hiring platform where job seekers (candidates) can be found and get contacted and hired by companies' hiring managers.

The platform is free for job seekers, but not for companies.
The billing is handled by using a wallet. At the start each company has a wallet with 20 coins of credit.
These coins can be used to contact candidates and contacting a candidate will cost the company 5 coins.

On the candidates' list there is a button `Contact` and this is where a company can contact a candidate.
Similarly, the button `Hire` is where a company can hire a candidate.

One of the tasks for this test assignment is to implement the `Contact a candidate` feature which should consist of the following:
when a company contacts a candidate, we should send an email to that candidate and charge the company 5 coins from its wallet.

The other feature that is part of this test assignment is to `Hire a candidate`.
When a company hires a candidate we should mark the candidate as `hired`, put back 5 coins in the wallet of the company, and send an email to the candidate to tell them they were hired.
A company can hire only candidates that they have contacted before.

On the front end side, there's a couple of small things we'd like to see you change / implement:
 * When a strength is found within the array of desired strengths (present already in the component under data) change the background color of the badge to green
 * Pick any two soft skills you wish from the seeded ones, and make your own desiredSkills list. Apply the same background color change, but aim to use the same piece of code used for highlighting skills.
 * Hide the candidates that know Wordpress from the user, without actually removing their corresponding html elements
 * Include the MvpCandidates component at the bottom of the candidates page, and make sure to filter the people array to only display the correct ones based on the isMvp flag

Aside from the features, we're aware that this app is far from perfect, so we'd like you to fix/improve anything that you find to be wrong or needs improvement (code, architecture, naming, readability, robustness, etc.).

## Keypoints

While doing this test assignment, please pay attention to these aspects:

- Security 
    - we do not want to be hacked
- Best practices 
    - code should be clean and easy to maintain
- Documentation 
    - provide information on how to set up the project 
    - bonus points for a Docker setup
- Tests 
    - test the parts that you feel necessary to
- Logic 
    - pay attention to the constraints throughout the test assignment
- Commits
  - use granular commits containing a message for what you did in there

## Notes

- Authentication **IS NOT** in the scope of this assignment.
- The list of candidates, the company and the wallet are predefined and there is no need to create new ones.
- The emails that should be sent to the candidates can consist of only text, no design is needed.
