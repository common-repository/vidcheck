=== Plugin Name ===
Contributors: factly
Tags: vidcheck, fact check, factly, videos, fake news
Requires at least: 5.0
Tested up to: 5.8.1
Stable tag: 1.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

VidCheck makes video fact-checking standardized for fact-checkers, easy to read, understand for audiences, & scalable for platforms, fact-checkers.

== Description ==

VidCheck is a web platform that makes video fact-checking more standardized for fact-checkers, easy to read and understand for audiences, and scalable for platforms & fact-checkers. VidCheck can be used in cases where claims being fact-checked are part of the video such as political speeches, news content, documentaries, any other type of commentary, manipulated content, etc.

The current model of fact-checking claims in videos is to pick specific parts of the video where claims are seen or where manipulations are made and fact-check them. Usually, fact-checkers use timestamps in their article to identify the claims/manipulations if it's a longer video. They then fact-check the identified claims. This process has certain drawbacks such as fact-checkers going through lengthy videos to identify claims, audiences opening the video, and navigating to specific parts of the video.

VidCheck aims to solve these issues and present a refreshingly new & intuitive UI for these types of fact-checks.

VidCheck's WordPress plugin is for organizations that are running their websites on WordPress and would like the features of VidCheck within the same instance. While the core features of the plugin are same as the standalone version, there are a few features that are not supported through the WordPress plugin. A detailed document will be published at a later time highlighting the difference in features between the WordPress plugin and the self-hosted version of VidCheck.

== Calling files remotely ==

VidCheck uses an external service called [Vumbnail](https://vumbnail.com/), to provide the thumbnail images for Vimeo Videos within the Plugin.

== Frequently Asked Questions ==

= How does it benefit Fact-Checkers? =

Fact-checkers need to identify the timestamps (from & to) where claims are made in the video that is to be fact-checked. They enter these timelines in VidCheck and the specific claim being made at that specific time. VidCheck then enables them to write their research, fact-check for these claims. In the case of manipulated videos or out-of-context videos, fact-checkers will identify & enter the time frames used for the purpose of evidence or clues. The relevant clip or the GIF will automatically be a part of the fact-check without having to manually embed or take screenshots. We also plan to integrate all this into the original videos so that reading the fact-check becomes a seamless exercise. Claim Review schema is populated automatically for published fact checks.

== Screenshots ==

1. Vidcheck Ratings List
2. Vidcheck Claimants List
3. VidCheck List
4. Add New Fact Check
5. Fill Add New Fact Check
6. View of Vidcheck after creation
7. List of VidChecks for Users
8. Single VidCheck View

= How does it benefit Audience? =

For the audience, this will be a completely new & refreshing experience. If it's a political speech, especially the ones made during election campaigns, the reader will be able to watch the specific clip where the claim is made, read the claim, and the fact-check, all at one place without having to go back & forth in the video. The audiences can read the fact-check claim by claim where they can watch the clip, read the fact-check in a refreshingly new UI. They don't need to watch lengthy videos just to see where the claim is made. In the case of manipulated or out-of-context videos, the audience can watch the clip where relevant evidence or clues are identified by the fact-checker. They can also watch GIFs generated with the identified evidence or clue used for fact-checking. Audience can jump to a certain claim in the video by clicking through the list of claims & also get a graphical view of all the ratings for the claims. Readers can also send URLs to the videos to fact-checkers specifying the timings of the claims they would like to fact-check. Fact-checkers will receive the submissions in their queue and can choose to publish a fact check for the same.

= How does it benefit Platforms? =

VidCheck solves an important problem for platforms as far as misinformation with videos is concerned. It is immensely useful for a platform like YouTube because all the information entered in VidCheck is exposed as an API which can be used to add additional context and information in the videos presented on the platform.

All in all, VidCheck makes this entire process a part of the fact-checking workflow. Hence without any additional efforts, the entire ecosystem will benefit.

= How is the project funded? =
VidCheck is one of the projects started at Factly Labs as a part of its initiatives under Journalism Technology. VidCheck was one of the winners for IFCN's Fact-Checking Development Grant Program and was funded early on by this grant.

Similar to all our open source projects at Factly, we plan to sustain VidCheck's development through an internal development team in collaboration with the open source community. While we have a free open source version of VidCheck available for anyone to self-host, we will also run a managed service for a subscription fee for organisations/users that do not have the resources to deploy and manage VidCheck on their own.

== Changelog ==

= 1.0 =

- This is the first version of VidCheck plugin.
