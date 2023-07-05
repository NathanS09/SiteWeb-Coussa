using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Text.RegularExpressions;

public class FacebookPost
{
    public string Message { get; set; }
    public DateTime CreatedTime { get; set; }
}

public class FacebookPageScraper
{
    private readonly HttpClient _httpClient;

    public FacebookPageScraper()
    {
        _httpClient = new HttpClient();
    }

    public async Task<List<FacebookPost>> GetLatestPosts(string pageUrl, int limit = 3)
    {
        var response = await _httpClient.GetAsync(pageUrl);
        if (response.IsSuccessStatusCode)
        {
            var content = await response.Content.ReadAsStringAsync();
            return ParsePosts(content, limit);
        }

        return null;
    }

    private List<FacebookPost> ParsePosts(string htmlContent, int limit)
    {
        // Utilisez des expressions régulières ou un autre mécanisme de parsing pour extraire les informations des posts du HTML de la page.
        // Voici un exemple de code pour extraire le texte du post et la date de création :

        var posts = new List<FacebookPost>();

        // Utilisez des expressions régulières pour extraire les informations des posts
        var postPattern = @"<div class=""fb-post""[^>]+>[\s\S]*?<div class=""userContent"">([\s\S]*?)<\/div>[\s\S]*?<abbr[^>]+title=""(\d+\/\d+\/\d+)\s+(\d+:\d+ [APM]{2})"">";
        var regex = new Regex(postPattern, RegexOptions.IgnoreCase);
        var matches = regex.Matches(htmlContent);

        foreach (Match match in matches)
        {
            if (posts.Count >= limit)
                break;

            var message = match.Groups[1].Value.Trim();
            var date = DateTime.Parse($"{match.Groups[2].Value} {match.Groups[3].Value}");

            posts.Add(new FacebookPost { Message = message, CreatedTime = date });
        }

        return posts;
    }
}
